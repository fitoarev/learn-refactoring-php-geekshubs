<?php

namespace Refactoring\Task;

use Refactoring\Dao;
use Refactoring\Mailer;

class Queue
{
    protected $_dao = null;

    public function setDao(Dao $dao)
    {
        $this->_dao = $dao;
    }

    protected $_mailer = null;

    public function setMailer(Mailer $mailer)
    {
        $this->_mailer = $mailer;
    }

    protected $_debugInfo = array();

    public function addDebugInfo($key, $message)
    {
        if (!array_key_exists($key, $this->_debugInfo)) {
            $this->_debugInfo[$key] = array();
        }
        $this->_debugInfo[$key][] = $message;
    }

    public function getDebugInfo()
    {
        return $this->_debugInfo;
    }

    public function run()
    {
        $queues = $this->_dao->fetchAll('queues');

        foreach ($queues as $queueId => $queue) {
            if (ORDER_STATUS_PAID === $queue['orderStatus']) {
                $this->handlePaid($queue);
            } elseif (ORDER_STATUS_INVOICE === $queue['orderStatus']) {
                $this->handleInvoice($queue);
            } elseif (ORDER_STATUS_DELIVERED === $queue['orderStatus']) {
                $this->handleDelivered($queue);
            } elseif (ORDER_STATUS_CLOSED === $queue['orderStatus']) {
                $this->handleClosed($queue);
            }

            // 刪除舊的 Queue
            $where = array(
                'queueId = ?' => $queueId,
            );
            $this->_dao->delete('queues', $where);
        }
    }

    /**
     * @param $queue
     */
    private function handlePaid($queue)
    {
        $order = array(
            'orderStatus' => ORDER_STATUS_PAID,
        );
        $where = array(
            'orderNumber = ?' => $queue['orderNumber'],
        );
        $this->_dao->update('orders', $order, $where);

        $this->addDebugInfo('Status ' . $order['orderStatus'], $queue['orderNumber']);
    }

    /**
     * @param $queue
     */
    private function handleInvoice($queue)
    {
        $order = array(
            'invoiceNumber' => $queue['invoiceNumber'],
            'orderStatus' => ORDER_STATUS_INVOICE,
        );
        $where = array(
            'orderNumber = ?' => $queue['orderNumber'],
        );
        $this->_dao->update('orders', $order, $where);

        $this->addDebugInfo('Status ' . $order['orderStatus'], $queue['orderNumber']);

        // 寄送發票通知
        $order = $this->_dao->fetchRow('orders', $where);
        $this->_mailer->setSubject('訂單 ' . $order['orderNumber'] . ' 發票通知');
        $this->_mailer->setBody('發票通知內容');
        $this->_mailer->setFrom('service@company.com');
        $this->_mailer->addAddress($order['shopperEmail']);
        $this->_mailer->send();
    }

    /**
     * @param $queue
     */
    private function handleDelivered($queue)
    {
        $order = array(
            'deliverNumber' => $queue['deliverNumber'],
            'orderStatus' => ORDER_STATUS_DELIVERED,
        );
        $where = array(
            'orderNumber = ?' => $queue['orderNumber'],
        );
        $this->_dao->update('orders', $order, $where);

        $this->addDebugInfo('Status ' . $order['orderStatus'], $queue['orderNumber']);

        // 寄送出貨通知
        $order = $this->_dao->fetchRow('orders', $where);
        $this->_mailer->setSubject('訂單 ' . $order['orderNumber'] . ' 出貨通知');
        $this->_mailer->setBody('出貨通知內容');
        $this->_mailer->setFrom('service@company.com');
        $this->_mailer->addAddress($order['receiverEmail']);
        $this->_mailer->send();
    }

    /**
     * @param $queue
     */
    private function handleClosed($queue)
    {
        $order = array(
            'orderStatus' => ORDER_STATUS_CLOSED,
        );
        $where = array(
            'orderNumber = ?' => $queue['orderNumber'],
        );
        $this->_dao->update('orders', $order, $where);

        $this->addDebugInfo('Status ' . $order['orderStatus'], $queue['orderNumber']);
    }
}
