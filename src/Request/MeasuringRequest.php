<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\When;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MeasuringRequest extends BaseRequest
{
    protected $type;

    protected $value;

    protected $color;

    protected $temperature;

    protected $graduation;

    protected $ph;


    public function getColor()
    {
        return $this->color;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getGraduation()
    {
        return $this->graduation;
    }

    public function getPh()
    {
        return $this->ph;
    }

    public function isTypeSelected(): bool
    {
        return $this->type != null && $this->type != "all";
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $choices = ['all', 'color', 'temp', 'grad', 'ph'];

        $metadata->addPropertyConstraint(
            'type',
            new Choice([
                'choices' => $choices,
                'message' => 'You must select one of the following: '
                    . implode(', ', $choices),
            ])
        );

        $metadata->addPropertyConstraint(
            'value',
            new When([
                'expression' => 'this.isTypeSelected()',
                'constraints' => [
                    new NotBlank([], 'Value cannot be blank if an specific type is selected'),
                ],
            ])
        );

        $message = 'At least one of the fields must not be blank';

        $metadata->addPropertyConstraint(
            'color',
            new When([
                'expression' => '!this.isTypeSelected()
                    && this.getTemperature() == null
                    && this.getGraduation() == null
                    && this.getPh() == null',
                'constraints' => [
                    new NotBlank([], $message),
                ],
            ])
        );

        $metadata->addPropertyConstraint(
            'temperature',
            new When([
                'expression' => '!this.isTypeSelected()
                    && this.getColor() == null
                    && this.getGraduation() == null
                    && this.getPh() == null',
                'constraints' => [
                    new NotBlank([], $message),
                ],
            ])
        );

        $metadata->addPropertyConstraint(
            'graduation',
            new When([
                'expression' => '!this.isTypeSelected()
                    && this.getColor() == null
                    && this.getTemperature() == null
                    && this.getPh() == null',
                'constraints' => [
                    new NotBlank([], $message),
                ],
            ])
        );

        $metadata->addPropertyConstraint(
            'ph',
            new When([
                'expression' => '!this.isTypeSelected()
                    && this.getColor() == null
                    && this.getTemperature() == null
                    && this.getGraduation() == null',
                'constraints' => [
                    new NotBlank([], $message),
                ],
            ])
        );
    }
}
