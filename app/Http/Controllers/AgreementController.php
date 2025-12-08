<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AgreementController extends Controller
{
    /**
     * Generate investment agreement for active investment
     */
    public function generate(Investment $investment)
    {
        // Only allow for active investments (roi_status = pending)
        if ($investment->roi_status !== 'pending') {
            return back()->with('error', 'Agreements can only be generated for active investments.');
        }

        // Load investor relationship
        $investment->load('investor');

        // Determine cycle type and generate appropriate agreement
        $cycleType = $investment->investment_type; // 'single_cycle' or 'double_cycle'
        
        // Generate agreement based on cycle type
        $agreementPath = $this->generateAgreementDocument($investment, $cycleType);

        if (!$agreementPath) {
            return back()->with('error', 'Failed to generate agreement document.');
        }

        // Download the generated agreement
        return response()->download(storage_path('app/' . $agreementPath))->deleteFileAfterSend();
    }

    /**
     * Generate agreement document using Node.js and docx library
     */
    private function generateAgreementDocument(Investment $investment, string $cycleType)
    {
        $investor = $investment->investor;
        
        // Prepare data for the agreement
        $data = [
            'investorName' => $investor->name,
            'investorAddress' => $investor->company ?? 'N/A',
            'investmentAmount' => number_format($investment->investment_amount, 2),
            'investmentAmountWords' => $this->numberToWords($investment->investment_amount),
            'roiAmount' => number_format($investment->roi_amount, 2),
            'roiAmountWords' => $this->numberToWords($investment->roi_amount),
            'totalReturn' => number_format($investment->investment_amount + $investment->roi_amount, 2),
            'totalReturnWords' => $this->numberToWords($investment->investment_amount + $investment->roi_amount),
            'investmentDate' => $investment->investment_date->format('jS \o\f F, Y'),
            'roiDate' => $investment->roi_date->format('jS \o\f F, Y'),
            'cycleType' => $cycleType,
            'investmentPeriod' => $cycleType === 'double_cycle' ? 'twelve (12) months' : 'six (6) months',
            'todayDate' => Carbon::now()->format('jS \o\f F, Y'),
        ];

        // For double cycle, calculate mid-cycle date (first ROI payment)
        if ($cycleType === 'double_cycle') {
            $midCycleDate = $investment->investment_date->copy()->addMonths(6);
            $data['firstCycleDate'] = $midCycleDate->format('jS \o\f F, Y');
            $data['secondCycleDate'] = $investment->roi_date->format('jS \o\f F, Y');
            $data['firstCycleTimeline'] = $investment->investment_date->format('jS \o\f F, Y') . ' - ' . $midCycleDate->format('jS \o\f F, Y');
            $data['secondCycleTimeline'] = $midCycleDate->format('jS \o\f F, Y') . ' - ' . $investment->roi_date->format('jS \o\f F, Y');
            $data['profitOnly'] = number_format($investment->roi_amount / 2, 2); // Split profit over 2 cycles
            $data['profitOnlyWords'] = $this->numberToWords($investment->roi_amount / 2);
        }

        
       // Save data as JSON for Node.js script
$dataPath = 'agreements/data_' . $investment->id . '.json';
$fullDataPath = storage_path('app/' . $dataPath);

// Ensure directory exists
$directory = dirname($fullDataPath);
if (!file_exists($directory)) {
    mkdir($directory, 0777, true);
}

file_put_contents($fullDataPath, json_encode($data));

        // Generate unique filename
        $outputFilename = 'agreement_' . $investment->id . '_' . time() . '.docx';
        $outputPath = 'agreements/' . $outputFilename;

        // Create Node.js script to generate the document
        $scriptPath = $this->createGeneratorScript($cycleType);
        
       // Run Node.js script
$result = Process::run([
    'node',
    $scriptPath,
    storage_path('app/' . $dataPath),
    storage_path('app/' . $outputPath)
]);

// Clean up temporary script file
@unlink($scriptPath);

if ($result->successful()) {
    // Clean up JSON file after successful generation
    @unlink($fullDataPath);
    return $outputPath;
}

return null;
    }

    /**
     * Create Node.js script for document generation
     */
    private function createGeneratorScript(string $cycleType): string
    {
        $scriptContent = $cycleType === 'double_cycle' 
            ? $this->getDoubleCycleScript() 
            : $this->getSingleCycleScript();

       $scriptPath = storage_path('app/agreements/generate_agreement.cjs');
        
        // Ensure directory exists
        if (!file_exists(dirname($scriptPath))) {
            mkdir(dirname($scriptPath), 0755, true);
        }
        
        file_put_contents($scriptPath, $scriptContent);
        
        return $scriptPath;
    }

    /**
     * Get single cycle agreement generation script
     */
    private function getSingleCycleScript(): string
    {
        return <<<'JS'
const fs = require('fs');
const { Document, Packer, Paragraph, TextRun, AlignmentType, HeadingLevel } = require('docx');

// Read input data
const dataPath = process.argv[2];
const outputPath = process.argv[3];
const data = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

// Create document
const doc = new Document({
    sections: [{
        properties: {},
        children: [
            // Header
            new Paragraph({
                text: "TWINTIAMIYU AGROSERVICES",
                heading: HeadingLevel.HEADING_1,
                alignment: AlignmentType.CENTER,
                spacing: { after: 200 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Address: 146, Ojuleyingbo Street, Ikija-Ijebu, Ogun-State", bold: true }),
                ]
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Phone: 08134629683, 09131131704, 08126883766", bold: true }),
                ],
                spacing: { after: 100 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Email: twinsagroservices@gmail.com RC NO: 8151199", bold: true }),
                ],
                spacing: { after: 400 }
            }),
            
            // Title
            new Paragraph({
                text: "INVESTMENT AGREEMENT",
                heading: HeadingLevel.HEADING_2,
                alignment: AlignmentType.CENTER,
                spacing: { after: 400 }
            }),
            
            // Introduction
            new Paragraph({
                children: [
                    new TextRun({ text: `This Investment Agreement is made and entered into on this Day ${data.todayDate} between ` }),
                    new TextRun({ text: "TWINSTIAMIYU AGROSERVICES", bold: true }),
                    new TextRun({ text: ", located at Isire road Ikija Ijebu, and " }),
                    new TextRun({ text: data.investorName.toUpperCase(), bold: true }),
                    new TextRun({ text: ", " + data.investorAddress + "." }),
                ],
                spacing: { after: 400 }
            }),
            
            // Section 1
            new Paragraph({
                text: "1. Investment Details",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: `1.1. The Investor agrees to invest the sum of ${data.investmentAmountWords} (₦${data.investmentAmount}) in the fish farming business operated by Twinstiamiyu agroservices.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "1.2. The investment will be used solely for the purpose of expanding and managing the fish farming operations at Twinstiamiyu agroservices.",
                spacing: { after: 400 }
            }),
            
            // Section 2
            new Paragraph({
                text: "2. Return on Investment",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "2.1. Twinstiamiyu agroservices agrees to pay the Investor a return of twenty percent (20%) on the invested amount.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: `2.2. The total return, which includes the initial investment plus the 20% return, will be ${data.totalReturnWords} (₦${data.totalReturn}), unless the Investor chooses to renew the investment.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "2.3. If the Investor chooses to renew the investment for another six-month period, only the twenty percent (20%) return will be paid out, while the initial capital will remain invested with Twinstiamiyu agroservices.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "2.4. The Investor may also choose to add to the initial investment amount upon renewal. Any additional investment will be subject to the same terms and conditions outlined in this Agreement.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "2.5. The Investor must notify Twinstiamiyu agroservices in writing at least 25 days before the end of the current investment period if they wish to renew or add to the investment.",
                spacing: { after: 400 }
            }),
            
            // Section 3
            new Paragraph({
                text: "3. Investment Period",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: `3.1. The investment period is ${data.investmentPeriod} from the date the investment is received by Twinstiamiyu agroservices.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: `3.2. The return on investment, along with the initial investment, will be paid to the Investor at the end of the six-month period which is ${data.roiDate}.`,
                spacing: { after: 400 }
            }),
            
            // Section 4
            new Paragraph({
                text: "4. Payment Terms",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "4.1. Payment of the return on investment will be made via Bank Transfer to the bank account details provided by the Investor.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "4.2. The payment will be made no later than 6 months from the investment date.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "4.3. Twinstiamiyu agroservices reserves the right to extend the payment date by an additional one (1) week in the event of unforeseen marketing issues or delays that affect the sale and distribution of the fish farming products. The Investor will be notified in advance if such an extension is necessary.",
                spacing: { after: 400 }
            }),
            
            // Section 5
            new Paragraph({
                text: "5. Confidentiality",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "Both parties agree to keep the terms of this Agreement and any related business information confidential.",
                spacing: { after: 600 }
            }),
            
            // Signature Block
            new Paragraph({
                children: [
                    new TextRun({ text: data.investorName, bold: true }),
                ],
                spacing: { before: 600, after: 200 }
            }),
            new Paragraph({
                text: "Representative's Name: _________________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Representative's Signature: _____________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Date: __________________",
                spacing: { after: 400 }
            }),
            
            new Paragraph({
                children: [
                    new TextRun({ text: "Twinstiamiyu Agroservices", bold: true }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "Representative's Name: Tiamiyu Kehinde",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Representative's Signature: _____________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Date: __________________",
                spacing: { after: 200 }
            }),
        ]
    }]
});

// Generate and save
Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync(outputPath, buffer);
    ('Document generated successfully');
});
JS;
    }

    /**
     * Get double cycle agreement generation script
     */
    private function getDoubleCycleScript(): string
    {
        return <<<'JS'
const fs = require('fs');
const { Document, Packer, Paragraph, TextRun, AlignmentType, HeadingLevel } = require('docx');

// Read input data
const dataPath = process.argv[2];
const outputPath = process.argv[3];
const data = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

// Create document (similar structure but with double cycle terms)
const doc = new Document({
    sections: [{
        properties: {},
        children: [
            // Header (same as single cycle)
            new Paragraph({
                text: "TWINTIAMIYU AGROSERVICES",
                heading: HeadingLevel.HEADING_1,
                alignment: AlignmentType.CENTER,
                spacing: { after: 200 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Address: 146, Ojuleyingbo Street, Ikija-Ijebu, Ogun-State", bold: true }),
                ]
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Phone: 08134629683, 09131131704, 08126883766", bold: true }),
                ],
                spacing: { after: 100 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Email: twinsagroservices@gmail.com RC NO: 8151199", bold: true }),
                ],
                spacing: { after: 400 }
            }),
            
            // Title
            new Paragraph({
                text: "INVESTMENT AGREEMENT",
                heading: HeadingLevel.HEADING_2,
                alignment: AlignmentType.CENTER,
                spacing: { after: 400 }
            }),
            
            // Introduction
            new Paragraph({
                children: [
                    new TextRun({ text: `This Investment Agreement is made and entered into on this Day ${data.todayDate} between ` }),
                    new TextRun({ text: "TWINSTIAMIYU AGROSERVICES", bold: true }),
                    new TextRun({ text: ", located at Isire road Ikija Ijebu, and " }),
                    new TextRun({ text: data.investorName.toUpperCase(), bold: true }),
                    new TextRun({ text: ", " + data.investorAddress + "." }),
                ],
                spacing: { after: 400 }
            }),
            
            // Section 1
            new Paragraph({
                text: "1. Investment Details",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: `1.1. The Investor agrees to invest the sum of ${data.investmentAmountWords} (₦${data.investmentAmount}) in the fish farming business operated by Twinstiamiyu agroservices.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "1.2. The investment will be used solely for the purpose of expanding and managing the fish farming operations at Twinstiamiyu agroservices.",
                spacing: { after: 400 }
            }),
            
            // Section 2 - Double Cycle Terms
            new Paragraph({
                text: "2. Return on Investment",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "2.1. Twinstiamiyu agroservices agrees to pay the Investor a return of twenty percent (20%) on the invested amount per cycle.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: `2.2. The total return, which includes the initial investment plus the 20% return, will be ${data.totalReturnWords} (₦${data.totalReturn}).`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: `2.3. Total payable to investor first cycle, only the profit of ${data.profitOnlyWords} (₦${data.profitOnly}) will be returned after the first cycle, with the capital reinvested for the second cycle.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: `2.4. Total payable to investor after second cycle will be ${data.totalReturnWords} (₦${data.totalReturn}), which includes the investment capital and the profit for the second cycle.`,
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "2.5. The Investor may also choose to add to the initial investment amount upon renewal. Any additional investment will be subject to the same terms and conditions outlined in this Agreement.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "2.6. The Investor must notify Twinstiamiyu agroservices in writing at least 25 days before the end of the current investment period if they wish to renew or add to the investment.",
                spacing: { after: 400 }
            }),
            
            // Section 3
            new Paragraph({
                text: "3. Investment Period",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: `3.1. The investment period is ${data.investmentPeriod} from the date the investment is received by Twinstiamiyu agroservices.`,
                spacing: { after: 400 }
            }),
            
            // Section 4 - Payment Terms with Timeline
            new Paragraph({
                text: "4. Payment Terms",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "4.1. Payment of the return on investment will be made via Bank Transfer to the bank account details provided by the Investor.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "4.2. Twinstiamiyu agroservices reserves the right to extend the payment date by an additional one (1) week in the event of unforeseen marketing issues or delays that affect the sale and distribution of the fish farming products. The Investor will be notified in advance if such an extension is necessary.",
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.3 Project Timeline:", bold: true }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "First Cycle: ", bold: true }),
                    new TextRun({ text: data.firstCycleTimeline }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Second Cycle: ", bold: true }),
                    new TextRun({ text: data.secondCycleTimeline }),
                ],
                spacing: { after: 400 }
            }),
            
            // Section 5
            new Paragraph({
                text: "5. Confidentiality",
                heading: HeadingLevel.HEADING_3,
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "Both parties agree to keep the terms of this Agreement and any related business information confidential.",
                spacing: { after: 600 }
            }),
            
            // Signature Block
            new Paragraph({
                children: [
                    new TextRun({ text: data.investorName, bold: true }),
                ],
                spacing: { before: 600, after: 200 }
            }),
            new Paragraph({
                text: "Representative's Name: _________________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Representative's Signature: _____________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Date: __________________",
                spacing: { after: 400 }
            }),
            
            new Paragraph({
                children: [
                    new TextRun({ text: "Twinstiamiyu Agroservices", bold: true }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                text: "Representative's Name: Tiamiyu Kehinde",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Representative's Signature: _____________________________________",
                spacing: { after: 200 }
            }),
            new Paragraph({
                text: "Date: __________________",
                spacing: { after: 200 }
            }),
        ]
    }]
});

// Generate and save
Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync(outputPath, buffer);
});
JS;
    }

    /**
     * Convert number to words (Nigerian format)
     */
    private function numberToWords($number): string
    {
        $number = (int) $number;
        
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        
        if ($number == 0) return 'Zero Naira';
        
        $words = '';
        
        // Millions
        if ($number >= 1000000) {
            $millions = floor($number / 1000000);
            $words .= $this->convertHundreds($millions, $ones, $tens, $teens) . ' Million ';
            $number %= 1000000;
        }
        
        // Thousands
        if ($number >= 1000) {
            $thousands = floor($number / 1000);
            $words .= $this->convertHundreds($thousands, $ones, $tens, $teens) . ' Thousand ';
            $number %= 1000;
        }
        
        // Hundreds
        if ($number > 0) {
            $words .= $this->convertHundreds($number, $ones, $tens, $teens);
        }
        
        return trim($words) . ' Naira';
    }
    
    private function convertHundreds($number, $ones, $tens, $teens): string
    {
        $words = '';
        
        if ($number >= 100) {
            $hundreds = floor($number / 100);
            $words .= $ones[$hundreds] . ' Hundred ';
            $number %= 100;
        }
        
        if ($number >= 20) {
            $words .= $tens[floor($number / 10)] . ' ';
            $number %= 10;
        }
        
        if ($number >= 10) {
            $words .= $teens[$number - 10] . ' ';
            return $words;
        }
        
        if ($number > 0) {
            $words .= $ones[$number] . ' ';
        }
        
        return $words;
    }
}