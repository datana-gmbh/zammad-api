<?php

declare(strict_types=1);

namespace Datana\Zammad\Api\Domain\Value;

use OskarStark\Value\TrimmedNonEmptyString;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Safe\sprintf;

final class Ticket
{
    /**
     * @var array<mixed>
     */
    private array $values;

    /**
     * @param UploadedFile[] $attachments
     */
    public function __construct(
        string $title,
        string $message,
        string $aktenzeichen,
        array $attachments,
        string $email,
        string $nachname,
        string $group = 'Kundensupport',
        string $note = 'Nachricht aus dem Mandantencockpit',
        string $tags = 'Sonstige Dokumente'
    ) {
        $values = [
            'title' => $title,
            'group' => $group,
            'customer_id' => sprintf('guess:%s', $email),
            'state' => 'open',
            'internal' => false,
            'kontaktform_aktenzeichen' => TrimmedNonEmptyString::fromString($aktenzeichen)->toString(),
            'kontaktform_email' => $email,
            'kontaktform_nachname' => $nachname,
            'article' => [
                'subject' => $title,
                'body' => $message,
            ],
            'note' => $note,
            'tags' => $tags,
        ];

        foreach ($attachments as $attachment) {
            $values['article']['attachments'][] = [
                'filename' => $attachment->getClientOriginalName(),
                'data' => base64_encode($attachment->getContent()),
                'mime-type' => $attachment->getMimeType(),
            ];
        }

        $this->values = $values;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return $this->values;
    }
}
