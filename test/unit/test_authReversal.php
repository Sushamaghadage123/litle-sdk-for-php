<?php
/*
 * Copyright (c) 2011 Litle & Co.
 * 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
require_once("../../simpletest/autorun.php");
require_once('../../simpletest/unit_tester.php');
require_once('../../simpletest/mock_objects.php');
require_once realpath(dirname(__FILE__)) . '/../../lib/LitleOnline.php';
Mock::generate('communication');
Mock::generate('LitleXmlMapper');
class authReversal_UnitTest extends UnitTestCase
{
	function test_capture()
	{
		$hash_in = array('litleTxnId'=> '1234567890','reportGroup'=>'Planets', 'amount'=>'5000');
		$mappTest = &new MockLitleXmlMapper();
		$commTest = &new Mockcommunication();
		$mappTest->expectOnce('request',array(new PatternExpectation('/.*<litleTxnId>1234567890.*<amount>5000.*/'),array("user"=>NULL,"password"=>NULL,"merchantId"=>NULL,"reportGroup"=>"Planets","id"=>NULL,"version"=>NULL,"url"=>NULL,"timeout"=>NULL,"proxy"=>NULL)));
		$litleTest = &new LitleOnlineRequest();
		$litleTest->newXML = $mappTest;
		$retOb = $litleTest->authReversalRequest($hash_in);
	}
	
	function test_no_txnid()
	{
		$hash_in =array('reportGroup'=>'Planets','amount'=>'106');
		$litleTest = &new LitleOnlineRequest();
		$this->expectException(new Exception("Missing Required Field: /litleTxnId/"));
		$retOb = $litleTest->authReversalRequest($hash_in);
	}
}
