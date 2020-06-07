<?php

declare(strict_types=1);

namespace WebApp\Tests\Views;

use PHPUnit\Framework\TestCase;
use WebApp\Views\FurnitureView;
use WebApp\Models\Furniture;
use WebApp\Util\ProductPopulator;
use WebApp\Bootstrap;
use Doctrine\ORM\EntityManager;

class FurnitureControllerTest extends TestCase implements IProductViewTest
{
    protected FurnitureView $furnitureView;

    protected static EntityManager $em;

    private static array $dbParams = array('url' => "mysql://dev_admin:p455w0rd@127.0.0.1:3306/my_db");

    public static function setUpBeforeClass(): void
    {
        $bootstrap = new Bootstrap();
        self::$em = $bootstrap->createEntityManager(self::$dbParams);
    }

    public static function tearDownAfterClass(): void
    {
        self::$em->clear();
        self::$em->close();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->furnitureView = new FurnitureView(self::$em);

        //populate database with dummy records
        $populator = new ProductPopulator(self::$em);
        $populator->populate(Furniture::class, 10);
    }

    protected function tearDown(): void
    {

        $className = Furniture::class;
        self::$em->createQuery("DELETE FROM $className")->execute();
        assert(count(self::$em->getRepository(Furniture::class)->findAll()) === 0);
    }

    /**
     * {@inheritDoc}
     * @see \WebApp\Tests\Views\IProductViewTest::testDisplayAllOutputsValidHTML()
     */
    public function testDisplayAllOutputsValidHTML()
    {
        //Arrange
        //set up to catch DomDocument errors
        libxml_use_internal_errors(true);
        $domDoc = new \DOMDocument();

        //Act
        $output = $this->furnitureView->displayAll();
        $output = implode($output);
        $domDoc->loadHTML($output);

        $output_file = fopen("/tmp/output__" . $this->getName() . ".html", "w");
        //use 'output' variable from testcase with html string
        fwrite($output_file, $output);
        if (count(libxml_get_errors()) > 0) {
            var_dump(libxml_get_errors());
        }

        //Assert
        $this->assertCount(0, libxml_get_errors());
    }

    public function testDisplayFormOutputsValidHTML()
    {
        //Arrange
        libxml_use_internal_errors(true);
        $domDoc = new \DOMDocument();

        //Act
        $output = $this->furnitureView->displayForm();
        $domDoc->loadHTML($output);

        $output_file = fopen("/tmp/output__" . $this->getName() . ".html", "w");
        //use 'output' variable from testcase with html string
        fwrite($output_file, $output);
        if (count(libxml_get_errors()) > 0) {
            var_dump(libxml_get_errors());
        }

        //Assert
        $this->assertCount(0, libxml_get_errors());
    }
}
