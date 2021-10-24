<?php 

namespace tuefekci\helpers;

use PHPUnit\Framework\TestCase;

/**
*  Tests for helpers\Arrays
*
*  @author Giacomo Tüfekci
*/
class ArraysTest extends TestCase
{
    /**
     * Just check if the Arrays Class has no syntax errors
     */
    public function testIsThereAnySyntaxError()
    {
        $object = new arrays();
        $this->assertTrue(is_object($object));
    }

    /**
     * Test Prev
     */
    public function testPrev()
    {
        $data = $this->getArray(10);

        $this->assertEquals($data[5], arrays::prev($data, 6));
        $this->assertEquals(false, arrays::next($data, 11));
    }

    /**
     * Test Next
     */
    public function testNext()
    {
        $data = $this->getArray(10);

        $this->assertEquals($data[5], arrays::next($data, 4));
        $this->assertEquals(false, arrays::next($data, 11));
    }

     /**
     * Test Neighbors
     */
    public function testNeighbors()
    {
        $data = $this->getArray(10);
        $neighbors = arrays::neighbors($data, 4);

        $this->assertEquals($data[3], $neighbors['prev']);
        $this->assertEquals($data[5], $neighbors['next']);

        $this->assertEquals(false, arrays::neighbors($data, 11));
    }


    /**
     * Data for Arrays
     *
     * @return array
     */
    public function getArray($length = 10): array
    {
        $faker = \Faker\Factory::create('fr_FR');
        $values = [];
        for ($i = 0; $i < $length; $i++) {
            // get a random digit, but always a new one, to avoid duplicates
            $values[] = $faker->name();
        }
        return $values;
    }

}