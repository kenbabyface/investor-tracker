<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AgreementController extends Controller
{
    public function generate(Investment $investment)
    {
        if ($investment->roi_status !== 'pending') {
            return back()->with('error', 'Agreements can only be generated for active investments.');
        }

        $investment->load('investor');

        $cycleType = $investment->investment_type; 
        $agreementPath = $this->generateAgreementDocument($investment, $cycleType);

        if (!$agreementPath) {
            return back()->with('error', 'Failed to generate agreement document.');
        }
        return response()->download(storage_path('app/' . $agreementPath))->deleteFileAfterSend();
    }

    private function generateAgreementDocument(Investment $investment, string $cycleType)
    {
        $investor = $investment->investor;
        
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
            'agreementDate' => $investment->investment_date->format('jS \o\f F, Y'),
        ];

        if ($cycleType === 'double_cycle') {
            $midCycleDate = $investment->investment_date->copy()->addMonths(6);
            $endCycleDate = $investment->investment_date->copy()->addMonths(12);
            $data['firstCycleDate'] = $midCycleDate->format('jS \o\f F, Y');
            $data['secondCycleDate'] = $endCycleDate->format('jS \o\f F, Y');
            $data['firstCycleTimeline'] = $investment->investment_date->format('jS \o\f F, Y') . ' - ' . $midCycleDate->format('jS \o\f F, Y');
            $data['secondCycleTimeline'] = $midCycleDate->format('jS \o\f F, Y') . ' - ' . $endCycleDate->format('jS \o\f F, Y');
            $data['profitOnly'] = number_format($investment->roi_amount, 2);
            $data['profitOnlyWords'] = $this->numberToWords($investment->roi_amount);
        }

        $dataPath = 'agreements/data_' . $investment->id . '.json';
        $fullDataPath = storage_path('app/' . $dataPath);

        $directory = dirname($fullDataPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($fullDataPath, json_encode($data));

        $outputFilename = 'agreement_' . $investment->id . '_' . time() . '.docx';
        $outputPath = 'agreements/' . $outputFilename;

        $scriptPath = $this->createGeneratorScript($cycleType);
        
        $result = Process::run([
            'node',
            $scriptPath,
            storage_path('app/' . $dataPath),
            storage_path('app/' . $outputPath)
        ]);

        @unlink($scriptPath);

        if ($result->successful()) {
            @unlink($fullDataPath);
            return $outputPath;
        }

        

        return null;
    }

    private function createGeneratorScript(string $cycleType): string
    {
        $scriptContent = $cycleType === 'double_cycle' 
            ? $this->getDoubleCycleScript() 
            : $this->getSingleCycleScript();

        $scriptPath = storage_path('app/agreements/generate_agreement.cjs');
        
        if (!file_exists(dirname($scriptPath))) {
            mkdir(dirname($scriptPath), 0755, true);
        }
        
        file_put_contents($scriptPath, $scriptContent);
        
        return $scriptPath;
    }

    private function getSingleCycleScript(): string
    {
        return <<<'JS'
const fs = require('fs');
const { Document, Packer, Paragraph, TextRun, AlignmentType } = require('docx');

const dataPath = process.argv[2];
const outputPath = process.argv[3];
const data = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

const doc = new Document({
    sections: [{
        properties: {},
        children: [
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "TWINTIAMIYU AGROSERVICES", bold: true, size: 32 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Address: 146, Ojuleyingbo Street, Ikija-Ijebu, Ogun-State", bold: true, size: 22 }),
                ]
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Phone: 08134629683, 09131131704, 08126883766", bold: true, size: 22 }),
                ],
                spacing: { after: 100 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Email: twinsagroservices@gmail.com RC NO: 8151199", bold: true, size: 22 }),
                ],
                spacing: { after: 500 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "INVESTMENT AGREEMENT", bold: true, size: 28 }),
                ],
                spacing: { after: 500 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `This Investment Agreement is made and entered into on this Day ${data.agreementDate} between `, size: 22 }),
                    new TextRun({ text: "TWINSTIAMIYU AGROSERVICES", bold: true, size: 22 }),
                    new TextRun({ text: ", located at Isire road Ikija Ijebu, and ", size: 22 }),
                    new TextRun({ text: data.investorName.toUpperCase(), bold: true, size: 22 }),
                    new TextRun({ text: ", " + data.investorAddress + ".", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "1. Investment Details", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `1.1. The Investor agrees to invest the sum of ${data.investmentAmountWords} (₦${data.investmentAmount}) in the fish farming business operated by Twinstiamiyu agroservices.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "1.2. The investment will be used solely for the purpose of expanding and managing the fish farming operations at Twinstiamiyu agroservices.", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2. Return on Investment", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.1. Twinstiamiyu agroservices agrees to pay the Investor a return of twenty percent (20%) on the invested amount.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `2.2. The total return, which includes the initial investment plus the 20% return, will be ${data.totalReturnWords} (₦${data.totalReturn}), unless the Investor chooses to renew the investment.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.3. If the Investor chooses to renew the investment for another six-month period, only the twenty percent (20%) return will be paid out, while the initial capital will remain invested with Twinstiamiyu agroservices.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.4. The Investor may also choose to add to the initial investment amount upon renewal. Any additional investment will be subject to the same terms and conditions outlined in this Agreement.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.5. The Investor must notify Twinstiamiyu agroservices in writing at least 25 days before the end of the current investment period if they wish to renew or add to the investment.", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "3. Investment Period", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `3.1. The investment period is ${data.investmentPeriod} from the date the investment is received by Twinstiamiyu agroservices.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `3.2. The return on investment, along with the initial investment, will be paid to the Investor at the end of the six-month period which is ${data.roiDate}.`, size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4. Payment Terms", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.1. Payment of the return on investment will be made via Bank Transfer to the bank account details provided by the Investor.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.2. The payment will be made no later than 6 months from the investment date.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.3. Twinstiamiyu agroservices reserves the right to extend the payment date by an additional one (1) week in the event of unforeseen marketing issues or delays that affect the sale and distribution of the fish farming products. The Investor will be notified in advance if such an extension is necessary.", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "5. Confidentiality", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Both parties agree to keep the terms of this Agreement and any related business information confidential.", size: 22 }),
                ],
                spacing: { after: 600 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: data.investorName, bold: true, size: 22 }),
                ],
                spacing: { before: 600, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Name: _________________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Signature: _____________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Date: __________________", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Twinstiamiyu Agroservices", bold: true, size: 22 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Name: Tiamiyu Kehinde", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Signature: _____________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Date: __________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
        ]
    }]
});

Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync(outputPath, buffer);
    console.log('Document generated successfully');
});
JS;
    }

    private function getDoubleCycleScript(): string
    {
        return <<<'JS'
const fs = require('fs');
const { Document, Packer, Paragraph, TextRun, AlignmentType } = require('docx');

const dataPath = process.argv[2];
const outputPath = process.argv[3];
const data = JSON.parse(fs.readFileSync(dataPath, 'utf8'));

const doc = new Document({
    sections: [{
        properties: {},
        children: [
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "TWINTIAMIYU AGROSERVICES", bold: true, size: 32 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Address: 146, Ojuleyingbo Street, Ikija-Ijebu, Ogun-State", bold: true, size: 22 }),
                ]
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Phone: 08134629683, 09131131704, 08126883766", bold: true, size: 22 }),
                ],
                spacing: { after: 100 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "Email: twinsagroservices@gmail.com RC NO: 8151199", bold: true, size: 22 }),
                ],
                spacing: { after: 500 }
            }),
            new Paragraph({
                alignment: AlignmentType.CENTER,
                children: [
                    new TextRun({ text: "INVESTMENT AGREEMENT", bold: true, size: 28 }),
                ],
                spacing: { after: 500 }
            }),
            new Paragraph({
                children: [
                   new TextRun({ text: `This Investment Agreement is made and entered into on this Day ${data.agreementDate} between `, size: 22 }),
                    new TextRun({ text: "TWINSTIAMIYU AGROSERVICES", bold: true, size: 22 }),
                    new TextRun({ text: ", located at Isire road Ikija Ijebu, and ", size: 22 }),
                    new TextRun({ text: data.investorName.toUpperCase(), bold: true, size: 22 }),
                    new TextRun({ text: ", " + data.investorAddress + ".", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "1. Investment Details", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `1.1. The Investor agrees to invest the sum of ${data.investmentAmountWords} (₦${data.investmentAmount}) in the fish farming business operated by Twinstiamiyu agroservices.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "1.2. The investment will be used solely for the purpose of expanding and managing the fish farming operations at Twinstiamiyu agroservices.", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2. Return on Investment", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.1. Twinstiamiyu agroservices agrees to pay the Investor a return of twenty percent (20%) on the invested amount per cycle.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `2.2. The total return, which includes the initial investment plus the 20% return, will be ${data.totalReturnWords} (₦${data.totalReturn}).`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `2.3. Total payable to investor first cycle, only the profit of ${data.profitOnlyWords} (₦${data.profitOnly}) will be returned after the first cycle, with the capital reinvested for the second cycle.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `2.4. Total payable to investor after second cycle will be ${data.totalReturnWords} (₦${data.totalReturn}), which includes the investment capital and the profit for the second cycle.`, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.5. The Investor may also choose to add to the initial investment amount upon renewal. Any additional investment will be subject to the same terms and conditions outlined in this Agreement.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "2.6. The Investor must notify Twinstiamiyu agroservices in writing at least 25 days before the end of the current investment period if they wish to renew or add to the investment.", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "3. Investment Period", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: `3.1. The investment period is ${data.investmentPeriod} from the date the investment is received by Twinstiamiyu agroservices.`, size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4. Payment Terms", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.1. Payment of the return on investment will be made via Bank Transfer to the bank account details provided by the Investor.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.2. Twinstiamiyu agroservices reserves the right to extend the payment date by an additional one (1) week in the event of unforeseen marketing issues or delays that affect the sale and distribution of the fish farming products. The Investor will be notified in advance if such an extension is necessary.", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "4.3 Project Timeline:", bold: true, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "First Cycle: ", bold: true, size: 22 }),
                    new TextRun({ text: data.firstCycleTimeline, size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Second Cycle: ", bold: true, size: 22 }),
                    new TextRun({ text: data.secondCycleTimeline, size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "5. Confidentiality", bold: true, size: 24 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Both parties agree to keep the terms of this Agreement and any related business information confidential.", size: 22 }),
                ],
                spacing: { after: 600 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: data.investorName, bold: true, size: 22 }),
                ],
                spacing: { before: 600, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Name: _________________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Signature: _____________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Date: __________________", size: 22 }),
                ],
                spacing: { after: 400 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Twinstiamiyu Agroservices", bold: true, size: 22 }),
                ],
                spacing: { before: 400, after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Name: Tiamiyu Kehinde", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Representative's Signature: _____________________________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
            new Paragraph({
                children: [
                    new TextRun({ text: "Date: __________________", size: 22 }),
                ],
                spacing: { after: 200 }
            }),
        ]
    }]
});

Packer.toBuffer(doc).then((buffer) => {
    fs.writeFileSync(outputPath, buffer);
    console.log('Document generated successfully');
});
JS;
    }

    private function numberToWords($number): string
    {
        $number = (int) $number;
        
        $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        
        if ($number == 0) return 'Zero Naira';
        
        $words = '';
        
        if ($number >= 1000000) {
            $millions = floor($number / 1000000);
            $words .= $this->convertHundreds($millions, $ones, $tens, $teens) . ' Million ';
            $number %= 1000000;
        }
        
        if ($number >= 1000) {
            $thousands = floor($number / 1000);
            $words .= $this->convertHundreds($thousands, $ones, $tens, $teens) . ' Thousand ';
            $number %= 1000;
        }
        
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