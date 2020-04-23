<?php

namespace Telegram\Bot\Objects;

/**
 * Class Poll.
 *
 * @link https://core.telegram.org/bots/api#poll
 *
 * @property string       $id                       Unique poll identifier
 * @property string       $question                 Poll question, 1-255 characters.
 * @property PollOption[] $options                  List of poll options
 * @property int          $total_voter_count        Total number of users that voted in the poll
 * @property bool         $is_closed                True, if the poll is closed.
 * @property bool         $is_anonymous             True, if the poll is anonymous.
 * @property string       $type                     Poll type, currently can be “regular” or “quiz”
 * @property bool         $allow_multiple_answers   True, if the poll allows multiple answers.
 * @property int          $correct_option_id        (Optional). 0-based identifier of the correct answer option. Available only for polls in the quiz mode, which are closed, or was sent (not forwarded) by the bot or to the private chat with the bot.
 */
class Poll
{
    public function relations(): array
    {
        return [
            'options' => PollOption::class,
        ];
    }
}
