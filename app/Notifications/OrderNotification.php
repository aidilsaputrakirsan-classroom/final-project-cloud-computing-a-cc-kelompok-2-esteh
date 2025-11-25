<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $type; // create|update|delete|paid
    protected $message;

    public function __construct($order, string $type, string $message = null)
    {
        $this->order = $order;
        $this->type = $type;
        $this->message = $message ?? $this->defaultMessage();
    }

    protected function defaultMessage()
    {
        switch ($this->type) {
            case 'paid':
                return "Pembayaran berhasil untuk Order #{$this->order->id}.";
            case 'create':
                return "Order #{$this->order->id} dibuat.";
            case 'update':
                return "Order #{$this->order->id} diperbarui.";
            case 'delete':
                return "Order #{$this->order->id} dihapus.";
            default:
                return "Aktivitas pada Order #{$this->order->id}.";
        }
    }

    public function via($notifiable)
    {
        // hanya disimpan di database (in-app)
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id ?? null,
            'type' => $this->type,
            'message' => $this->message,
            'total' => $this->order->total ?? null,
            'transaction_id' => $this->order->transaction_id ?? null,
        ];
    }
}
