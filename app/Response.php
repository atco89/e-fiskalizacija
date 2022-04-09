<?php
declare(strict_types=1);

namespace Fiskalizacija;

use DateTime;
use Exception;
use Fiskalizacija\Entities\TaxItem;
use stdClass;

final class Response
{

    /**
     * @var stdClass
     */
    private stdClass $response;

    /**
     * @param stdClass $response
     */
    public function __construct(stdClass $response)
    {
        $this->response = $response;
    }

    /**
     * UID of client's Secure Element digital certificate.
     *
     * @return string
     */
    public function requestedBy(): string
    {
        return $this->response->requestedBy;
    }

    /**
     * UID of SDC`s Secure Element digital certificate.
     *
     * @return string
     */
    public function signedBy(): string
    {
        return $this->response->signedBy;
    }

    /**
     * Local date and time in ISO 8601 format provided by E-SDC.
     *
     * @return DateTime
     * @throws Exception
     */
    public function sdcDateTime(): DateTime
    {
        return new DateTime($this->response->sdcDateTime);
    }

    /**
     * Interfaces Counter in format transactionTypeCounter/totalCounter invoiceCounterExtension for example: 14/17NS.
     *
     * @return string
     */
    public function invoiceCounter(): string
    {
        return $this->response->invoiceCounter;
    }

    /**
     * First letters of Transaction Type and Interfaces Type of the invoice.
     * NS for Normal Sale,
     * CR – Copy Refund,
     * TS – Training Sale, etc.
     *
     * @return string
     */
    public function invoiceCounterExtension(): string
    {
        return $this->response->invoiceCounterExtension;
    }

    /**
     * SDC Interfaces Number in format requestedBy-signedBy-totalCounter.
     *
     * @return string
     */
    public function invoiceNumber(): string
    {
        return $this->response->invoiceNumber;
    }

    /**
     * VerificationURL generated in the Create Verification URL process.
     *
     * @return string
     */
    public function verificationUrl(): string
    {
        return $this->response->verificationUrl;
    }

    /**
     * Base64 encoded byte array of GIF image created in the Create QR Code process.
     *
     * @return string
     */
    public function verificationQRCode(): string
    {
        return $this->response->verificationQRCode;
    }

    /**
     * Textual Representation of the invoice created in the Creation a Textual Representation of an Interfaces process.
     *
     * @return string
     */
    public function journal(): string
    {
        return $this->response->journal;
    }

    /**
     * Total number of invoices signed by Secure Element. Returned by Sign Interfaces APDU command.
     *
     * @return int
     */
    public function totalCounter(): int
    {
        return $this->response->totalCounter;
    }

    /**
     * Total number of invoices for a requested type. Returned by Sign Interfaces APDU command.
     *
     * @return int
     */
    public function transactionTypeCounter(): int
    {
        return $this->response->transactionTypeCounter;
    }

    /**
     * Sum of all Items – total payable by the customer.
     *
     * @return float
     */
    public function totalAmount(): float
    {
        return $this->response->totalAmount;
    }

    /**
     * Base64 encoded byte array returned by Sign Interfaces APDU command.
     *
     * @return string
     */
    public function encryptedInternalData(): string
    {
        return $this->response->encryptedInternalData;
    }

    /**
     * Base64 encoded byte array returned by Sign Interfaces APDU command.
     *
     * @return string
     */
    public function signature(): string
    {
        return $this->response->signature;
    }

    /**
     * Array of TaxItem entities.
     *
     * @return TaxItem[]
     */
    public function taxItems(): array
    {
        return array_map(function (stdClass $item): TaxItem {
            return new class($item) implements TaxItem {

                private stdClass $item;

                /**
                 * @param stdClass $item
                 */
                public function __construct(stdClass $item)
                {
                    $this->item = $item;
                }

                /**
                 * @return string
                 */
                public function label(): string
                {
                    return $this->item->label;
                }

                /**
                 * @return string
                 */
                public function categoryName(): string
                {
                    return $this->item->categoryName;
                }

                /**
                 * @return int
                 */
                public function categoryType(): int
                {
                    return $this->item->categoryType;
                }

                /**
                 * @return float
                 */
                public function rate(): float
                {
                    return $this->item->rate;
                }

                /**
                 * @return float
                 */
                public function amount(): float
                {
                    return $this->item->amount;
                }
            };
        }, $this->response->taxItems);
    }

    /**
     * Taxpayer Business Name obtained from digital certificate subject field.
     *
     * @return string
     */
    public function businessName(): string
    {
        return $this->response->businessName;
    }

    /**
     * Location Name obtained from digital certificate subject field.
     *
     * @return string
     */
    public function locationName(): string
    {
        return $this->response->locationName;
    }

    /**
     * Street address obtained from digital certificate subject field.
     *
     * @return string
     */
    public function address(): string
    {
        return $this->response->address;
    }

    /**
     * Tax Identification Number obtained from digital certificate subject field.
     *
     * @return string
     */
    public function tin(): string
    {
        return $this->response->tin;
    }

    /**
     * District obtained from digital certificate subject field.
     *
     * @return string
     */
    public function district(): string
    {
        return $this->response->district;
    }

    /**
     * Revision of taxes used in the calculation.
     *
     * @return int
     */
    public function taxGroupRevision(): int
    {
        return $this->response->taxGroupRevision;
    }

    /**
     * Manufacturer Registration Code is mandatory for audit package sent to the tax authority database,
     * but it's optional for invoice response sent to POS.
     * It always has the format MakeCode-SoftwareVersionCode-DeviceSerialNumber.
     * Explanation: MakeCode -unique 2 characters received from the tax authority during accreditation.
     * SoftwareVersionCode - unique 4 characters received during accreditation.
     * SoftwareVersionCode - unique 4 characters received from the tax authroty during accreditation.
     * DeviceSerialNumber - manufacturer serial number (max 32 characters) for each E-SDC installation.
     * All 3 elements of MRC are mandatory.
     *
     * @return string
     */
    public function mrc(): string
    {
        return $this->response->mrc;
    }

    /**
     * Custom human-readable message that shall be printed or displayed by POS.
     *
     * @return string|null
     */
    public function messages(): ?string
    {
        return $this->response->messages;
    }
}