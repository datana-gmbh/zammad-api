<?php

declare(strict_types=1);

namespace Datana\Zammad\Api\Tests\Unit\Domain\Value;

use Datana\Zammad\Api\Domain\Value\Ticket;
use Ergebnis\Test\Util\Helper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Safe\sprintf;

final class TicketTest extends TestCase
{
    use Helper;

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\BoolProvider::false()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\BoolProvider::true()
     */
    public function toArray(bool $withAttachments): void
    {
        $faker = self::faker();

        $title = $faker->sentence();
        $message = $faker->sentence();
        $aktenzeichen = $faker->word();

        $attachments = [];

        if ($withAttachments) {
            for ($i = 0; $faker->numberBetween(1, 3) > $i; ++$i) {
                $attachments[] = new UploadedFile(
                    $faker->filePath(),
                    sprintf('%s.%s', $faker->word(), $faker->fileExtension()),
                );
            }
        }

        $email = $faker->email();
        $nachname = $faker->userName();
        $group = $faker->word();
        $note = $faker->sentence();
        $tags = $faker->word();

        $expected = [
            'title' => $title,
            'group' => $group,
            'customer_id' => sprintf('guess:%s', $email),
            'state' => 'open',
            'internal' => false,
            'kontaktform_aktenzeichen' => $aktenzeichen,
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
            $expected['article']['attachments'][] = [
                'filename' => $attachment->getClientOriginalName(),
                'data' => base64_encode($attachment->getContent()),
                'mime-type' => $attachment->getMimeType(),
            ];
        }

        $ticket = new Ticket(
            $title,
            $message,
            $aktenzeichen,
            $attachments,
            $email,
            $nachname,
            $group,
            $note,
            $tags,
        );

        self::assertSame(
            $expected,
            $ticket->toArray(),
        );
    }
}
