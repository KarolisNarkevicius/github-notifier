<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class IssueCommentedNotification extends Notification
{
    use Queueable;

    private $issue;
    private $comment;
    private $repository;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($issue, $comment, $repository)
    {
        $this->issue = $issue;
        $this->comment = $comment;
        $this->repository = $repository;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New comment in:' . $this->repository['name'])
            ->line($this->issue['user']['login'] . ' commented in ' . $this->repository['name'] . ' on ' . $this->issue['name'])
            ->line('`' . $this->comment['body'] . '`')
            ->action('Go to the issue', $this->comment['html_url'])
            ->salutation('GitMailer');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
