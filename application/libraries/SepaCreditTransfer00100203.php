<?php
/**
 * Sephpa
 *
 * @license   GNU LGPL v3.0 - For details have a look at the LICENSE file
 * @copyright ©2016 Alexander Schickedanz
 * @link      https://github.com/AbcAeffchen/Sephpa
 *
 * @author    Alexander Schickedanz <abcaeffchen@gmail.com>
 */

//namespace AbcAeffchen\Sephpa;
//use SepaUtilities;

/**
 * Manages credit transfers
 */
class SepaCreditTransfer00100203 implements SepaPaymentCollection
{
    /**
     * @var string CCY Default currency
     */
    const CCY = 'EUR';
    /**
     * @type int VERSION The SEPA file version of this collection
     */
    const VERSION = SepaUtilities::SEPA_PAIN_001_002_03;
    /**
     * @type bool $sanitizeFlags
     */
    private $checkAndSanitize = true;
    /**
     * @type int $sanitizeFlags
     */
    private $sanitizeFlags = 0;
    /**
     * @var mixed[] $payments Saves all payments
     */
    private $payments = array();
    /**
     * @var mixed[] $transferInfo Saves the transfer information for the collection.
     */
    private $transferInfo;

    /**
     * @param mixed[] $transferInfo needed keys: 'pmtInfId', 'dbtr', 'iban', 'bic';
     *                              optional keys: 'ccy', 'btchBookg', 'ctgyPurp',
     *                              'reqdExctnDt', 'ultmtDebtr'
     * @param bool    $checkAndSanitize        All inputs will be checked and sanitized before creating
     *                              the collection. If you check the inputs yourself you can
     *                              set this to false.
     * @param int     $flags        The flags used for sanitizing
     * @throws SephpaInputException
     */
    public function __construct(array $transferInfo, $checkAndSanitize = true, $flags = 0)
    {
        $this->checkAndSanitize = $checkAndSanitize;
        $this->sanitizeFlags = $flags;

        // All required information is provided?
        if(!SepaUtilities::checkRequiredCollectionKeys($transferInfo, self::VERSION))
            throw new SephpaInputException('The values of \'pmtInfId\', \'dbtr\', \'iban\', \'bic\' must not be empty.');

        if($this->checkAndSanitize)
        {

            // All fields contain valid information?
            $checkResult = SepaUtilities::checkAndSanitizeAll($transferInfo, $this->sanitizeFlags);

            if($checkResult !== true)
                throw new SephpaInputException('The values of ' . $checkResult . ' are invalid.');

            // IBAN and BIC can belong to each other?
            if(!SepaUtilities::crossCheckIbanBic($transferInfo['iban'],$transferInfo['bic']))
                throw new SephpaInputException('IBAN and BIC do not belong to each other.');
        }

        $this->transferInfo = $transferInfo;
    }

    /**
     * Adds a payment to the payment collection
     *
     * @param mixed[] $paymentInfo needed keys: 'pmtId', 'instdAmt', 'iban', 'bic', 'cdtr';
     *                             optional keys: 'ultmtCdrt', 'purp', 'rmtInf'
     * @throws SephpaInputException
     * @return void
     */
    public function addPayment(array $paymentInfo)
    {
        if($this->checkAndSanitize)
        {
            if(!SepaUtilities::checkRequiredPaymentKeys($paymentInfo, self::VERSION) )
                throw new SephpaInputException('One of the required inputs \'pmtId\', \'instdAmt\', \'iban\', \'bic\', \'cdtr\' is missing.');

            $checkResult = SepaUtilities::checkAndSanitizeAll($paymentInfo, $this->sanitizeFlags);

            if($checkResult !== true)
                throw new SephpaInputException('The values of ' . $checkResult . ' are invalid.');

            // IBAN and BIC can belong to each other?
            if(!SepaUtilities::crossCheckIbanBic($paymentInfo['iban'],$paymentInfo['bic']))
                throw new SephpaInputException('IBAN and BIC do not belong to each other.');
        }

        $this->payments[] = $paymentInfo;
    }

    /**
     * Calculates the sum of all payments in this collection
     *
     * @return float
     */
    public function getCtrlSum()
    {
        $sum = 0;
        foreach($this->payments as $payment)
        {
            $sum += $payment['instdAmt'];
        }

        return $sum;
    }

    /**
     * counts the payments in this collection
     *
     * @return int
     */
    public function getNumberOfTransactions()
    {
        return count($this->payments);
    }

    /**
     * Generates the xml for the collection using generatePaymentXml
     *
     * @param \SimpleXMLElement $pmtInf The PmtInf-Child of the xml object
     * @return void
     */
    public function generateCollectionXml(\SimpleXMLElement $pmtInf)
    {
        $ccy = empty( $this->transferInfo['ccy'] )
            ? self::CCY
            : $this->transferInfo['ccy'];

        $datetime    = new \DateTime();
        $reqdExctnDt = isset( $this->transferInfo['reqdExctnDt'] )
            ? $this->transferInfo['reqdExctnDt'] : $datetime->format('Y-m-d');

        $pmtInf->addChild('PmtInfId', $this->transferInfo['pmtInfId']);
        $pmtInf->addChild('PmtMtd', 'TRF');
        if( !empty( $this->transferInfo['btchBookg'] ) )
            $pmtInf->addChild('BtchBookg', $this->transferInfo['btchBookg']);
        $pmtInf->addChild('NbOfTxs', $this->getNumberOfTransactions());
        $pmtInf->addChild('CtrlSum', sprintf('%01.2f', $this->getCtrlSum()));

        $pmtTpInf = $pmtInf->addChild('PmtTpInf');
        $pmtTpInf->addChild('InstrPrty', 'NORM');
        $pmtTpInf->addChild('SvcLvl')->addChild('Cd', 'SEPA');
        if( isset( $this->transferInfo['ctgyPurp'] ) )
            $pmtTpInf->addChild('CtgyPurp')->addChild('Cd', $this->transferInfo['ctgyPurp']);

        $pmtInf->addChild('ReqdExctnDt', $reqdExctnDt);
        $pmtInf->addChild('Dbtr')->addChild('Nm', $this->transferInfo['dbtr']);

        $dbtrAcct = $pmtInf->addChild('DbtrAcct');
        $dbtrAcct->addChild('Id')->addChild('IBAN', $this->transferInfo['iban']);
        $dbtrAcct->addChild('Ccy', $ccy);

        $pmtInf->addChild('DbtrAgt')->addChild('FinInstnId')
               ->addChild('BIC', $this->transferInfo['bic']);

        if( isset( $this->transferInfo['ultmtDbtr'] ) )
            $pmtInf->addChild('UltmtDbtr')->addChild('Nm', $this->transferInfo['ultmtDbtr']);

        $pmtInf->addChild('ChrgBr', 'SLEV');

        foreach($this->payments as $payment)
        {
            $cdtTrfTxInf = $pmtInf->addChild('CdtTrfTxInf');
            $this->generatePaymentXml($cdtTrfTxInf, $payment, $ccy);
        }
    }

    /**
     * generates the xml for a single payment
     *
     * @param \SimpleXMLElement $cdtTrfTxInf
     * @param mixed[]           $payment one of the payments in $this->payments
     * @param string            $ccy     currency
     * @return void
     */
    private function generatePaymentXml(\SimpleXMLElement $cdtTrfTxInf, $payment, $ccy)
    {
        $cdtTrfTxInf->addChild('PmtId')->addChild('EndToEndId', $payment['pmtId']);
        $cdtTrfTxInf->addChild('Amt')->addChild('InstdAmt', $payment['instdAmt'])
                    ->addAttribute('Ccy', $ccy);
        $cdtTrfTxInf->addChild('CdtrAgt')->addChild('FinInstnId')
                    ->addChild('BIC', $payment['bic']);
        $cdtTrfTxInf->addChild('Cdtr')->addChild('Nm', $payment['cdtr']);
        $cdtTrfTxInf->addChild('CdtrAcct')->addChild('Id')->addChild('IBAN', $payment['iban']);

        if( isset( $payment['ultmtCdtr'] ) )
            $cdtTrfTxInf->addChild('UltmtCdtr')->addChild('Nm', $payment['ultmtCdtr']);
        if( isset( $payment['purp'] ) )
            $cdtTrfTxInf->addChild('Purp')->addChild('Cd', $payment['purp']);
        if( isset( $payment['rmtInf'] ) )
            $cdtTrfTxInf->addChild('RmtInf')->addChild('Ustrd', $payment['rmtInf']);
    }

}
