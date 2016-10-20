<?php

class Task_QueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Task_Queue
     */
    protected $_task = null;

    /**
     * @var DaoMock
     */
    protected $_dao = null;

    /**
     * @var MailerMock
     */
    protected $_mailer = null;

    /**
     *
     * @var array
     */
    protected $_testData = array(
        'queues' => array(
            1 => array(
                'queueId' => 1,
                'orderNumber' => '2011050101',
                'orderStatus' => ORDER_STATUS_PAID,
                'invoiceNumber' => null,
                'deliverNumber' => null,
            ),
            2 => array(
                'queueId' => 2,
                'orderNumber' => '2011050102',
                'orderStatus' => ORDER_STATUS_INVOICE,
                'invoiceNumber' => 'AB12345678',
                'deliverNumber' => null,
            ),
            3 => array(
                'queueId' => 3,
                'orderNumber' => '2011050103',
                'orderStatus' => ORDER_STATUS_DELIVERED,
                'invoiceNumber' => null,
                'deliverNumber' => 'A123456',
            ),
            4 => array(
                'queueId' => 4,
                'orderNumber' => '2011050104',
                'orderStatus' => ORDER_STATUS_CLOSED,
                'invoiceNumber' => null,
                'deliverNumber' => null,
            ),
        ),
        'orders' => array(
            '2011050101' => array(
                'orderNumber' => '2011050101',
                'shopperEmail' => 'tester@example.com',
                'receiverEmail' => 'tester@example.com',
                'invoiceNumber' => null,
                'deliverNumber' => null,
                'orderStatus' => null,
            ),
            '2011050102' => array(
                'orderNumber' => '2011050102',
                'shopperEmail' => 'tester@example.com',
                'receiverEmail' => 'tester@example.com',
                'invoiceNumber' => null,
                'deliverNumber' => null,
                'orderStatus' => null,
            ),
            '2011050103' => array(
                'orderNumber' => '2011050103',
                'shopperEmail' => 'tester@example.com',
                'receiverEmail' => 'tester@example.com',
                'invoiceNumber' => null,
                'deliverNumber' => null,
                'orderStatus' => null,
            ),
            '2011050104' => array(
                'orderNumber' => '2011050104',
                'shopperEmail' => 'tester@example.com',
                'receiverEmail' => 'tester@example.com',
                'invoiceNumber' => null,
                'deliverNumber' => null,
                'orderStatus' => null,
            ),
        ),
    );

    protected function setUp()
    {
        $this->_task = new Task_Queue();
        $this->_dao = new DaoMock($this->_testData);
        $this->_mailer = new MailerMock();

        $this->_task->setDao($this->_dao);
        $this->_task->setMailer($this->_mailer);
    }

    protected function tearDown()
    {
        $this->_task = null;
        $this->_dao = null;
        $this->_mailer = null;
    }

    public function testRun()
    {
        $this->_task->run();

        $taskInfo = $this->_task->getDebugInfo();

        $this->assertArrayHasKey('Status ' . ORDER_STATUS_PAID, $taskInfo);
        $this->assertArrayHasKey('Status ' . ORDER_STATUS_INVOICE, $taskInfo);
        $this->assertArrayHasKey('Status ' . ORDER_STATUS_DELIVERED, $taskInfo);
        $this->assertArrayHasKey('Status ' . ORDER_STATUS_CLOSED, $taskInfo);

        $this->assertContains('2011050101', $taskInfo['Status ' . ORDER_STATUS_PAID]);
        $this->assertContains('2011050102', $taskInfo['Status ' . ORDER_STATUS_INVOICE]);
        $this->assertContains('2011050103', $taskInfo['Status ' . ORDER_STATUS_DELIVERED]);
        $this->assertContains('2011050104', $taskInfo['Status ' . ORDER_STATUS_CLOSED]);

        $mailerInfo = $this->_mailer->getDebugInfo();
        $this->assertArrayHasKey('訂單 2011050102 發票通知', $mailerInfo);
        $this->assertArrayHasKey('訂單 2011050103 出貨通知', $mailerInfo);
    }
}