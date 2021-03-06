<?php

/**
 * Flintstone Unit Tests
 */

class FeatureTest extends TestFixture {

	/**
	 * Test 'set' operations
	 */
	public function testSet() {
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertTrue($this->db->set('b', 2));
		$this->assertTrue($this->db->set('c', array(3, 4, 5)));
		$this->assertTrue($this->db->set('d', "some data == some new lines\r\n"));
		$this->assertSame($this->db->get('d'), "some data == some new lines\r\n");
	}

	/**
	 * Test 'set' operations
	 * @expectedException Flintstone\FlintstoneException
	 */
	public function testSetException() {
		$this->db->set('d', false);
	}

	/**
	 * Test invalid key
	 * @expectedException Flintstone\FlintstoneException
	 */
	public function testInvalidKey() {
		$this->db->get('test!123');
	}

	/**
	 * Test blank key
	 * @expectedException Flintstone\FlintstoneException
	 */
	public function testBlankKey() {
		$this->db->get('');
	}

	/**
	 * Test huge key
	 * @expectedException Flintstone\FlintstoneException
	 */
	public function testHugeKey() {
		$this->db->get(str_repeat('a', 100));
	}

	/**
	 * Test 'replace' operations
	 */
	public function testReplace() {
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertTrue($this->db->replace('a', '2'));
		$this->assertSame($this->db->get('a'), '2');
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertSame($this->db->get('a'), '1');
	}

	/**
	 * Test 'get' operations
	 */
	public function testGet() {
		$this->assertFalse($this->db->get('a'));
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertSame($this->db->get('a'), '1');
	}

	/**
	 * Test 'delete' operations
	 */
	public function testDelete() {
		$this->assertFalse($this->db->delete('a'));
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertTrue($this->db->delete('a'));
		$this->assertFalse($this->db->get('a'));
	}

	/**
	 * Test 'flush' operations
	 */
	public function testFlush() {
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertTrue($this->db->set('b', 2));
		$this->assertTrue($this->db->flush());
		$keys = $this->db->getKeys();
		$this->assertEquals(0, count($keys));
	}

	/**
	 * Test 'getKeys' operations
	 */
	public function testGetKeys() {
		$this->assertTrue($this->db->set('a', '1'));
		$this->assertTrue($this->db->set('b', 2));
		$this->assertTrue($this->db->set('c', array(3, 4, 5)));
		$keys = $this->db->getKeys();
		$this->assertEquals(3, count($keys));
		$this->assertContains('a', $keys);
	}
}