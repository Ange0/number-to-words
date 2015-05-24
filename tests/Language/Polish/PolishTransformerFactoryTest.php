<?php

namespace Kwn\NumberToWords\Language\Polish;


use Kwn\NumberToWords\Language\Polish\Transformer\Decorator\CurrencyTransformerDecorator;
use Kwn\NumberToWords\Model\Currency;

class PolishTransformerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PolishTransformerFactory
     */
    private $transformerFactory;

    public function setUp()
    {
        $this->transformerFactory = new PolishTransformerFactory();
    }

    public function testGetLanguageIdentifier()
    {
        $this->assertEquals(
            PolishTransformerFactory::LANGUAGE_IDENTIFIER,
            $this->transformerFactory->getLanguageIdentifier()
        );
    }

    public function testCreateNumberTransformerBuildsCorrectClass()
    {
        $numberTransformer = $this->transformerFactory->createNumberTransformer();

        $this->assertInstanceOf(
            'Kwn\NumberToWords\Language\Polish\Transformer\NumberTransformer',
            $numberTransformer
        );
    }

    public function testCreateCurrencyTransformerBuildsCorrectClass()
    {
        $currencyTransformer = $this->transformerFactory->createCurrencyTransformer(new Currency('PLN'));

        $this->assertInstanceOf(
            'Kwn\NumberToWords\Language\Polish\Transformer\Decorator\CurrencyTransformerDecorator',
            $currencyTransformer
        );

        $this->assertEquals(
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_WORDS,
            $this->readAttribute($currencyTransformer, 'subunitsFormat')
        );
    }

    public function testCreateCurrencyTransformerBuildClassWithCorrectSubunitsValue()
    {
        $currencyTransformer = $this->transformerFactory->createCurrencyTransformer(
            new Currency('PLN'),
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_WORDS
        );

        $this->assertEquals(
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_WORDS,
            $this->readAttribute($currencyTransformer, 'subunitsFormat')
        );

        $currencyTransformer = $this->transformerFactory->createCurrencyTransformer(
            new Currency('EUR'),
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_NUMBERS
        );

        $this->assertEquals(
            CurrencyTransformerDecorator::FORMAT_SUBUNITS_IN_NUMBERS,
            $this->readAttribute($currencyTransformer, 'subunitsFormat')
        );
    }
}