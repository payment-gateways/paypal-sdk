<?php

namespace PaymentGateway\PayPalSdk\Subscriptions;

class PaymentMethod
{
    private ?string $payerSelected;
    private ?string $payeePreferred;
    private ?string $standardEntryClassCode;

    public function getPayerSelected(): ?string
    {
        return $this->payerSelected;
    }

    public function setPayerSelected(?string $payerSelected): self
    {
        $this->payerSelected = $payerSelected;

        return $this;
    }

    public function getPayeePreferred(): ?string
    {
        return $this->payeePreferred;
    }

    public function setPayeePreferred(?string $payeePreferred): self
    {
        $this->payeePreferred = $payeePreferred;

        return $this;
    }

    public function getStandardEntryClassCode(): ?string
    {
        return $this->standardEntryClassCode;
    }

    public function setStandardEntryClassCode(?string $standardEntryClassCode): self
    {
        $this->standardEntryClassCode = $standardEntryClassCode;

        return $this;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->payerSelected) {
            $data['payer_selected'] = $this->payerSelected;
        }

        if ($this->payeePreferred) {
            $data['payee_preferred'] = $this->payeePreferred;
        }

        if ($this->standardEntryClassCode) {
            $data['standard_entry_class_code'] = $this->standardEntryClassCode;
        }

        return $data;
    }
}
