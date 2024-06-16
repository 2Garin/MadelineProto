<?php

declare(strict_types=1);

/**
 * RPCErrorException module.
 *
 * This file is part of MadelineProto.
 * MadelineProto is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * MadelineProto is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU General Public License along with MadelineProto.
 * If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Daniil Gentili <daniil@daniil.it>
 * @copyright 2016-2023 Daniil Gentili <daniil@daniil.it>
 * @license   https://opensource.org/licenses/AGPL-3.0 AGPLv3
 * @link https://docs.madelineproto.xyz MadelineProto documentation
 */

namespace danog\MadelineProto;

use Amp\Http\Client\HttpClientBuilder;
use Amp\Http\Client\Request;
use Throwable;

use const PHP_EOL;

use const PHP_SAPI;

/**
 * Indicates an error returned by Telegram's API.
 */
class RPCErrorException extends \Exception
{
    use TL\PrettyException;
    /** @internal */
    public static array $descriptions = ['RPC_MCGET_FAIL' => 'Telegram is having internal issues, please try again later.', 'RPC_CALL_FAIL' => 'Telegram is having internal issues, please try again later.', 'USER_PRIVACY_RESTRICTED' => "The user's privacy settings do not allow you to do this", 'CHANNEL_PRIVATE' => "You haven't joined this channel/supergroup", 'USER_IS_BOT' => "Bots can't send messages to other bots", 'BOT_METHOD_INVALID' => 'This method cannot be run by a bot', 'PHONE_CODE_EXPIRED' => 'The phone code you provided has expired, this may happen if it was sent to any chat on telegram (if the code is sent through a telegram chat (not the official account) to avoid it append or prepend to the code some chars)', 'USERNAME_INVALID' => 'The provided username is not valid', 'ACCESS_TOKEN_INVALID' => 'The provided token is not valid', 'ACTIVE_USER_REQUIRED' => 'The method is only available to already activated users', 'FIRSTNAME_INVALID' => 'The first name is invalid', 'LASTNAME_INVALID' => 'The last name is invalid', 'PHONE_NUMBER_INVALID' => 'The phone number is invalid', 'PHONE_CODE_HASH_EMPTY' => 'phone_code_hash is missing', 'PHONE_CODE_EMPTY' => 'phone_code is missing', 'API_ID_INVALID' => 'The api_id/api_hash combination is invalid', 'PHONE_NUMBER_OCCUPIED' => 'The phone number is already in use', 'PHONE_NUMBER_UNOCCUPIED' => 'The phone number is not yet being used', 'USERS_TOO_FEW' => 'Not enough users (to create a chat, for example)', 'USERS_TOO_MUCH' => 'The maximum number of users has been exceeded (to create a chat, for example)', 'TYPE_CONSTRUCTOR_INVALID' => 'The type constructor is invalid', 'FILE_PART_INVALID' => 'The file part number is invalid', 'FILE_PARTS_INVALID' => 'The number of file parts is invalid', 'MD5_CHECKSUM_INVALID' => 'The MD5 checksums do not match', 'PHOTO_INVALID_DIMENSIONS' => 'The photo dimensions are invalid', 'FIELD_NAME_INVALID' => 'The field with the name FIELD_NAME is invalid', 'FIELD_NAME_EMPTY' => 'The field with the name FIELD_NAME is missing', 'MSG_WAIT_FAILED' => 'A waiting call returned an error', 'USERNAME_NOT_OCCUPIED' => 'The provided username is not occupied', 'PHONE_NUMBER_BANNED' => 'The provided phone number is banned from telegram', 'AUTH_KEY_UNREGISTERED' => 'The authorization key has expired', 'INVITE_HASH_EXPIRED' => 'The invite link has expired', 'USER_DEACTIVATED' => 'The user was deactivated', 'USER_ALREADY_PARTICIPANT' => 'The user is already in the group', 'MESSAGE_ID_INVALID' => 'The provided message id is invalid', 'PEER_ID_INVALID' => 'The provided peer id is invalid', 'CHAT_ID_INVALID' => 'The provided chat id is invalid', 'MESSAGE_DELETE_FORBIDDEN' => "You can't delete one of the messages you tried to delete, most likely because it is a service message.", 'CHAT_ADMIN_REQUIRED' => 'You must be an admin in this chat to do this', -429 => 'Too many requests', 'PEER_FLOOD' => "You are spamreported, you can't do this"];
    /** @internal */
    public static array $errorMethodMap = [];
    private static array $fetchedError = [];

    private const BAD = [
        'PEER_FLOOD' => true,
        'USER_DEACTIVATED_BAN' => true,
        'INPUT_METHOD_INVALID' => true,
        'INPUT_FETCH_ERROR' => true,
        'AUTH_KEY_UNREGISTERED' => true,
        'SESSION_REVOKED' => true,
        'USER_DEACTIVATED' => true,
        'RPC_SEND_FAIL' => true,
        'RPC_CALL_FAIL' => true,
        'RPC_MCGET_FAIL' => true,
        'INTERDC_5_CALL_ERROR' => true,
        'INTERDC_4_CALL_ERROR' => true,
        'INTERDC_3_CALL_ERROR' => true,
        'INTERDC_2_CALL_ERROR' => true,
        'INTERDC_1_CALL_ERROR' => true,
        'INTERDC_5_CALL_RICH_ERROR' => true,
        'INTERDC_4_CALL_RICH_ERROR' => true,
        'INTERDC_3_CALL_RICH_ERROR' => true,
        'INTERDC_2_CALL_RICH_ERROR' => true,
        'INTERDC_1_CALL_RICH_ERROR' => true,
        'AUTH_KEY_DUPLICATED' => true,
        'CONNECTION_NOT_INITED' => true,
        'LOCATION_NOT_AVAILABLE' => true,
        'AUTH_KEY_INVALID' => true,
        'LANG_CODE_EMPTY' => true,
        'memory limit exit' => true,
        'memory limit(?)' => true,
        'INPUT_REQUEST_TOO_LONG' => true,
        'SESSION_PASSWORD_NEEDED' => true,
        'INPUT_FETCH_FAIL' => true,
        'CONNECTION_SYSTEM_EMPTY' => true,
        'FILE_WRITE_FAILED' => true,
        'STORAGE_CHOOSE_VOLUME_FAILED' => true,
        'xxx' => true,
        'AES_DECRYPT_FAILED' => true,
        'Timedout' => true,
        'SEND_REACTION_RESULT1_INVALID' => true,
        'BOT_POLLS_DISABLED' => true,
        'TEMPNAM_FAILED' => true,
        'MSG_WAIT_TIMEOUT' => true,
        'MEMBER_CHAT_ADD_FAILED' => true,
        'CHAT_FROM_CALL_CHANGED' => true,
        'MTPROTO_CLUSTER_INVALID' => true,
        'CONNECTION_DEVICE_MODEL_EMPTY' => true,
        'AUTH_KEY_PERM_EMPTY' => true,
        'UNKNOWN_METHOD' => true,
        'ENCRYPTION_OCCUPY_FAILED' => true,
        'ENCRYPTION_OCCUPY_ADMIN_FAILED' => true,
        'CHAT_OCCUPY_USERNAME_FAILED' => true,
        'REG_ID_GENERATE_FAILED' => true,
        'CONNECTION_LANG_PACK_INVALID' => true,
        'MSGID_DECREASE_RETRY' => true,
        'API_CALL_ERROR' => true,
        'STORAGE_CHECK_FAILED' => true,
        'INPUT_LAYER_INVALID' => true,
        'NEED_MEMBER_INVALID' => true,
        'NEED_CHAT_INVALID' => true,
        'HISTORY_GET_FAILED' => true,
        'CHP_CALL_FAIL' => true,
        'IMAGE_ENGINE_DOWN' => true,
        'MSG_RANGE_UNSYNC' => true,
        'PTS_CHANGE_EMPTY' => true,
        'CONNECTION_SYSTEM_LANG_CODE_EMPTY' => true,
        'WORKER_BUSY_TOO_LONG_RETRY' => true,
        'WP_ID_GENERATE_FAILED' => true,
        'ARR_CAS_FAILED' => true,
        'CHANNEL_ADD_INVALID' => true,
        'CHANNEL_ADMINS_INVALID' => true,
        'CHAT_OCCUPY_LOC_FAILED' => true,
        'GROUPED_ID_OCCUPY_FAILED' => true,
        'GROUPED_ID_OCCUPY_FAULED' => true,
        'LOG_WRAP_FAIL' => true,
        'MEMBER_FETCH_FAILED' => true,
        'MEMBER_OCCUPY_PRIMARY_LOC_FAILED' => true,
        'MEMBER_NO_LOCATION' => true,
        'MEMBER_OCCUPY_USERNAME_FAILED' => true,
        'MT_SEND_QUEUE_TOO_LONG' => true,
        'POSTPONED_TIMEOUT' => true,
        'RPC_CONNECT_FAILED' => true,
        'SHORTNAME_OCCUPY_FAILED' => true,
        'STORE_INVALID_OBJECT_TYPE' => true,
        'STORE_INVALID_SCALAR_TYPE' => true,
        'TMSG_ADD_FAILED' => true,
        'UNKNOWN_ERROR' => true,
        'UPLOAD_NO_VOLUME' => true,
        'USER_NOT_AVAILABLE' => true,
        'VOLUME_LOC_NOT_FOUND' => true,
        'FILE_WRITE_EMPTY' => true,
        'Internal_Server_Error' => true,
    ];

    /** @internal */
    public static function isBad(string $error, int $code, string $method): bool
    {
        return isset(self::BAD[$error])
                || str_contains($error, 'Received bad_msg_notification')
                || str_contains($error, 'FLOOD_WAIT_')
                || str_contains($error, '_MIGRATE_')
                || str_contains($error, 'INPUT_METHOD_INVALID')
                || str_contains($error, 'INPUT_CONSTRUCTOR_INVALID')
                || str_contains($error, 'INPUT_FETCH_ERROR_')
                || str_contains($error, 'https://telegram.org/dl')
                || str_starts_with($error, 'Received bad_msg_notification')
                || str_starts_with($error, 'No workers running')
                || str_starts_with($error, 'All workers are busy. Active_queries ')
                || preg_match('/FILE_PART_\d*_MISSING/', $error)
                || !preg_match('/^[a-zA-Z0-9\._]+$/', $method)
                || ($error === 'Timeout' && !\in_array(strtolower($method), ['messages.getbotcallbackanswer', 'messages.getinlinebotresults'], true))
                || ($error === 'BOT_MISSING' && \in_array($method, ['stickers.changeStickerPosition', 'stickers.createStickerSet', 'messages.uploadMedia'], true))
                || is_numeric($method);
    }

    /**
     * @internal
     */
    private static function report(string $error, int $code, string $method): string
    {
        if (!$method || !$code || !$error) {
            return $error;
        }
        $error = preg_replace('/\\d+$/', 'X', $error);
        $description = self::$descriptions[$error] ?? '';
        if ((!isset(self::$errorMethodMap[$code][$method][$error]) || !isset(self::$descriptions[$error]))
            && !self::isBad($error, $code, $method)
        ) {
            try {
                $res = json_decode(
                    (
                        HttpClientBuilder::buildDefault()
                        ->request(new Request('https://report-rpc-error.madelineproto.xyz/?method='.$method.'&code='.$code.'&error='.$error))
                    )->getBody()->buffer(),
                    true,
                );
                if (isset($res['ok']) && $res['ok'] && isset($res['result']) && \is_string($res['result'])) {
                    $description = $res['result'];
                    self::$descriptions[$error] = $description;
                    self::$errorMethodMap[$code][$method][$error] = $error;
                }
                self::$fetchedError[$error] = true;
            } catch (Throwable) {
            }
        }
        if (!$description) {
            return $error;
        }
        return $description;
    }
    /**
     * Get string representation of exception.
     */
    public function __toString(): string
    {
        Magic::start(light: true);
        $result = sprintf(Lang::$current_lang['rpc_tg_error'], $this->description." ({$this->code})", $this->rpc, $this->file, $this->line.PHP_EOL, Magic::$revision.PHP_EOL.PHP_EOL).PHP_EOL.$this->getTLTrace().PHP_EOL;
        if (PHP_SAPI !== 'cli' && PHP_SAPI !== 'phpdbg') {
            $result = str_replace(PHP_EOL, '<br>'.PHP_EOL, $result);
        }
        return $result;
    }
    /**
     * Get localized error name.
     */
    public function getLocalization(): string
    {
        return $this->description;
    }

    /**
     * @internal
     */
    public static function make(
        string $rpc,
        int $code,
        string $caller,
        ?\Exception $previous = null
    ): self {
        // Start match
        return match ($rpc) {
            'ABOUT_TOO_LONG' => new self($rpc, 'About string too long.', $code, $caller, $previous),
            'ACCESS_TOKEN_EXPIRED' => new self($rpc, 'Access token expired.', $code, $caller, $previous),
            'ACCESS_TOKEN_INVALID' => new self($rpc, 'Access token invalid.', $code, $caller, $previous),
            'ADDRESS_INVALID' => new self($rpc, 'The specified geopoint address is invalid.', $code, $caller, $previous),
            'ADMIN_ID_INVALID' => new self($rpc, 'The specified admin ID is invalid.', $code, $caller, $previous),
            'ADMIN_RANK_EMOJI_NOT_ALLOWED' => new self($rpc, 'An admin rank cannot contain emojis.', $code, $caller, $previous),
            'ADMIN_RANK_INVALID' => new self($rpc, 'The specified admin rank is invalid.', $code, $caller, $previous),
            'ADMIN_RIGHTS_EMPTY' => new self($rpc, 'The chatAdminRights constructor passed in keyboardButtonRequestPeer.peer_type.user_admin_rights has no rights set (i.e. flags is 0).', $code, $caller, $previous),
            'ADMINS_TOO_MUCH' => new self($rpc, 'There are too many admins.', $code, $caller, $previous),
            'ALBUM_PHOTOS_TOO_MANY' => new self($rpc, 'You have uploaded too many profile photos, delete some before retrying.', $code, $caller, $previous),
            'API_ID_INVALID' => new self($rpc, 'API ID invalid.', $code, $caller, $previous),
            'API_ID_PUBLISHED_FLOOD' => new self($rpc, 'This API id was published somewhere, you can\'t use it now.', $code, $caller, $previous),
            'ARTICLE_TITLE_EMPTY' => new self($rpc, 'The title of the article is empty.', $code, $caller, $previous),
            'AUDIO_CONTENT_URL_EMPTY' => new self($rpc, 'The remote URL specified in the content field is empty.', $code, $caller, $previous),
            'AUDIO_TITLE_EMPTY' => new self($rpc, 'An empty audio title was provided.', $code, $caller, $previous),
            'AUTH_BYTES_INVALID' => new self($rpc, 'The provided authorization is invalid.', $code, $caller, $previous),
            'AUTH_TOKEN_ALREADY_ACCEPTED' => new self($rpc, 'The specified auth token was already accepted.', $code, $caller, $previous),
            'AUTH_TOKEN_EXCEPTION' => new self($rpc, 'An error occurred while importing the auth token.', $code, $caller, $previous),
            'AUTH_TOKEN_EXPIRED' => new self($rpc, 'The authorization token has expired.', $code, $caller, $previous),
            'AUTH_TOKEN_INVALID' => new self($rpc, 'The specified auth token is invalid.', $code, $caller, $previous),
            'AUTH_TOKEN_INVALIDX' => new self($rpc, 'The specified auth token is invalid.', $code, $caller, $previous),
            'AUTOARCHIVE_NOT_AVAILABLE' => new self($rpc, 'The autoarchive setting is not available at this time: please check the value of the [autoarchive_setting_available field in client config &raquo;](https://core.telegram.org/api/config#client-configuration) before calling this method.', $code, $caller, $previous),
            'BANK_CARD_NUMBER_INVALID' => new self($rpc, 'The specified card number is invalid.', $code, $caller, $previous),
            'BANNED_RIGHTS_INVALID' => new self($rpc, 'You provided some invalid flags in the banned rights.', $code, $caller, $previous),
            'BOOST_NOT_MODIFIED' => new self($rpc, 'You\'re already [boosting](https://core.telegram.org/api/boost) the specified channel.', $code, $caller, $previous),
            'BOOST_PEER_INVALID' => new self($rpc, 'The specified `boost_peer` is invalid.', $code, $caller, $previous),
            'BOOSTS_EMPTY' => new self($rpc, 'No boost slots were specified.', $code, $caller, $previous),
            'BOOSTS_REQUIRED' => new self($rpc, 'The specified channel must first be [boosted by its users](https://core.telegram.org/api/boost) in order to perform this action.', $code, $caller, $previous),
            'BOT_APP_INVALID' => new self($rpc, 'The specified bot app is invalid.', $code, $caller, $previous),
            'BOT_APP_SHORTNAME_INVALID' => new self($rpc, 'The specified bot app short name is invalid.', $code, $caller, $previous),
            'BOT_CHANNELS_NA' => new self($rpc, 'Bots can\'t edit admin privileges.', $code, $caller, $previous),
            'BOT_COMMAND_DESCRIPTION_INVALID' => new self($rpc, 'The specified command description is invalid.', $code, $caller, $previous),
            'BOT_COMMAND_INVALID' => new self($rpc, 'The specified command is invalid.', $code, $caller, $previous),
            'BOT_DOMAIN_INVALID' => new self($rpc, 'Bot domain invalid.', $code, $caller, $previous),
            'BOT_GROUPS_BLOCKED' => new self($rpc, 'This bot can\'t be added to groups.', $code, $caller, $previous),
            'BOT_INLINE_DISABLED' => new self($rpc, 'This bot can\'t be used in inline mode.', $code, $caller, $previous),
            'BOT_INVALID' => new self($rpc, 'This is not a valid bot.', $code, $caller, $previous),
            'BOT_MISSING' => new self($rpc, 'Only bots can call this method, please use [@stickers](https://t.me/stickers) if you\'re a user.', $code, $caller, $previous),
            'BOT_ONESIDE_NOT_AVAIL' => new self($rpc, 'Bots can\'t pin messages in PM just for themselves.', $code, $caller, $previous),
            'BOT_PAYMENTS_DISABLED' => new \danog\MadelineProto\RPCError\BotPaymentsDisabledError($code, $caller, $previous),
            'BOT_RESPONSE_TIMEOUT' => new self($rpc, 'A timeout occurred while fetching data from the bot.', $code, $caller, $previous),
            'BOT_SCORE_NOT_MODIFIED' => new self($rpc, 'The score wasn\'t modified.', $code, $caller, $previous),
            'BOT_WEBVIEW_DISABLED' => new self($rpc, 'A webview cannot be opened in the specified conditions: emitted for example if `from_bot_menu` or `url` are set and `peer` is not the chat with the bot.', $code, $caller, $previous),
            'BOTS_TOO_MUCH' => new self($rpc, 'There are too many bots in this chat/channel.', $code, $caller, $previous),
            'BROADCAST_ID_INVALID' => new self($rpc, 'Broadcast ID invalid.', $code, $caller, $previous),
            'BROADCAST_PUBLIC_VOTERS_FORBIDDEN' => new \danog\MadelineProto\RPCError\BroadcastPublicVotersForbiddenError($code, $caller, $previous),
            'BROADCAST_REQUIRED' => new self($rpc, 'This method can only be called on a channel, please use stats.getMegagroupStats for supergroups.', $code, $caller, $previous),
            'BUTTON_DATA_INVALID' => new self($rpc, 'The data of one or more of the buttons you provided is invalid.', $code, $caller, $previous),
            'BUTTON_TEXT_INVALID' => new self($rpc, 'The specified button text is invalid.', $code, $caller, $previous),
            'BUTTON_TYPE_INVALID' => new self($rpc, 'The type of one or more of the buttons you provided is invalid.', $code, $caller, $previous),
            'BUTTON_URL_INVALID' => new self($rpc, 'Button URL invalid.', $code, $caller, $previous),
            'BUTTON_USER_INVALID' => new self($rpc, 'The `user_id` passed to inputKeyboardButtonUserProfile is invalid!', $code, $caller, $previous),
            'BUTTON_USER_PRIVACY_RESTRICTED' => new \danog\MadelineProto\RPCError\ButtonUserPrivacyRestrictedError($code, $caller, $previous),
            'CALL_ALREADY_ACCEPTED' => new \danog\MadelineProto\RPCError\CallAlreadyAcceptedError($code, $caller, $previous),
            'CALL_ALREADY_DECLINED' => new \danog\MadelineProto\RPCError\CallAlreadyDeclinedError($code, $caller, $previous),
            'CALL_OCCUPY_FAILED' => new self($rpc, 'The call failed because the user is already making another call.', $code, $caller, $previous),
            'CALL_PEER_INVALID' => new self($rpc, 'The provided call peer object is invalid.', $code, $caller, $previous),
            'CALL_PROTOCOL_FLAGS_INVALID' => new self($rpc, 'Call protocol flags invalid.', $code, $caller, $previous),
            'CDN_METHOD_INVALID' => new self($rpc, 'You can\'t call this method in a CDN DC.', $code, $caller, $previous),
            'CHANNEL_FORUM_MISSING' => new self($rpc, 'This supergroup is not a forum.', $code, $caller, $previous),
            'CHANNEL_ID_INVALID' => new self($rpc, 'The specified supergroup ID is invalid.', $code, $caller, $previous),
            'CHANNEL_INVALID' => new self($rpc, 'The provided channel is invalid.', $code, $caller, $previous),
            'CHANNEL_PARICIPANT_MISSING' => new self($rpc, 'The current user is not in the channel.', $code, $caller, $previous),
            'CHANNEL_PRIVATE' => new \danog\MadelineProto\RPCError\ChannelPrivateError($code, $caller, $previous),
            'CHANNEL_TOO_BIG' => new self($rpc, 'This channel has too many participants (>1000) to be deleted.', $code, $caller, $previous),
            'CHANNEL_TOO_LARGE' => new self($rpc, 'Channel is too large to be deleted; this error is issued when trying to delete channels with more than 1000 members (subject to change).', $code, $caller, $previous),
            'CHANNELS_ADMIN_LOCATED_TOO_MUCH' => new self($rpc, 'The user has reached the limit of public geogroups.', $code, $caller, $previous),
            'CHANNELS_ADMIN_PUBLIC_TOO_MUCH' => new self($rpc, 'You\'re admin of too many public channels, make some channels private to change the username of this channel.', $code, $caller, $previous),
            'CHANNELS_TOO_MUCH' => new self($rpc, 'You have joined too many channels/supergroups.', $code, $caller, $previous),
            'CHAT_ABOUT_NOT_MODIFIED' => new self($rpc, 'About text has not changed.', $code, $caller, $previous),
            'CHAT_ABOUT_TOO_LONG' => new self($rpc, 'Chat about too long.', $code, $caller, $previous),
            'CHAT_ADMIN_REQUIRED' => new \danog\MadelineProto\RPCError\ChatAdminRequiredError($code, $caller, $previous),
            'CHAT_DISCUSSION_UNALLOWED' => new self($rpc, 'You can\'t enable forum topics in a discussion group linked to a channel.', $code, $caller, $previous),
            'CHAT_FORWARDS_RESTRICTED' => new \danog\MadelineProto\RPCError\ChatForwardsRestrictedError($code, $caller, $previous),
            'CHAT_ID_EMPTY' => new self($rpc, 'The provided chat ID is empty.', $code, $caller, $previous),
            'CHAT_ID_INVALID' => new self($rpc, 'The provided chat id is invalid.', $code, $caller, $previous),
            'CHAT_INVALID' => new self($rpc, 'Invalid chat.', $code, $caller, $previous),
            'CHAT_INVITE_PERMANENT' => new self($rpc, 'You can\'t set an expiration date on permanent invite links.', $code, $caller, $previous),
            'CHAT_LINK_EXISTS' => new self($rpc, 'The chat is public, you can\'t hide the history to new users.', $code, $caller, $previous),
            'CHAT_NOT_MODIFIED' => new self($rpc, 'No changes were made to chat information because the new information you passed is identical to the current information.', $code, $caller, $previous),
            'CHAT_PUBLIC_REQUIRED' => new self($rpc, 'You can only enable join requests in public groups.', $code, $caller, $previous),
            'CHAT_RESTRICTED' => new \danog\MadelineProto\RPCError\ChatRestrictedError($code, $caller, $previous),
            'CHAT_REVOKE_DATE_UNSUPPORTED' => new self($rpc, '`min_date` and `max_date` are not available for using with non-user peers.', $code, $caller, $previous),
            'CHAT_SEND_INLINE_FORBIDDEN' => new self($rpc, 'You can\'t send inline messages in this group.', $code, $caller, $previous),
            'CHAT_TITLE_EMPTY' => new self($rpc, 'No chat title provided.', $code, $caller, $previous),
            'CHAT_TOO_BIG' => new self($rpc, 'This method is not available for groups with more than `chat_read_mark_size_threshold` members, [see client configuration &raquo;](https://core.telegram.org/api/config#client-configuration).', $code, $caller, $previous),
            'CHATLIST_EXCLUDE_INVALID' => new self($rpc, 'The specified `exclude_peers` are invalid.', $code, $caller, $previous),
            'CODE_EMPTY' => new self($rpc, 'The provided code is empty.', $code, $caller, $previous),
            'CODE_HASH_INVALID' => new self($rpc, 'Code hash invalid.', $code, $caller, $previous),
            'CODE_INVALID' => new self($rpc, 'Code invalid.', $code, $caller, $previous),
            'COLOR_INVALID' => new self($rpc, 'The specified color palette ID was invalid.', $code, $caller, $previous),
            'CONNECTION_API_ID_INVALID' => new self($rpc, 'The provided API id is invalid.', $code, $caller, $previous),
            'CONNECTION_APP_VERSION_EMPTY' => new self($rpc, 'App version is empty.', $code, $caller, $previous),
            'CONNECTION_LAYER_INVALID' => new self($rpc, 'Layer invalid.', $code, $caller, $previous),
            'CONTACT_ADD_MISSING' => new self($rpc, 'Contact to add is missing.', $code, $caller, $previous),
            'CONTACT_ID_INVALID' => new self($rpc, 'The provided contact ID is invalid.', $code, $caller, $previous),
            'CONTACT_MISSING' => new self($rpc, 'The specified user is not a contact.', $code, $caller, $previous),
            'CONTACT_NAME_EMPTY' => new self($rpc, 'Contact name empty.', $code, $caller, $previous),
            'CONTACT_REQ_MISSING' => new self($rpc, 'Missing contact request.', $code, $caller, $previous),
            'CREATE_CALL_FAILED' => new self($rpc, 'An error occurred while creating the call.', $code, $caller, $previous),
            'CURRENCY_TOTAL_AMOUNT_INVALID' => new self($rpc, 'The total amount of all prices is invalid.', $code, $caller, $previous),
            'CUSTOM_REACTIONS_TOO_MANY' => new self($rpc, 'Too many custom reactions were specified.', $code, $caller, $previous),
            'DATA_INVALID' => new self($rpc, 'Encrypted data invalid.', $code, $caller, $previous),
            'DATA_JSON_INVALID' => new self($rpc, 'The provided JSON data is invalid.', $code, $caller, $previous),
            'DATA_TOO_LONG' => new self($rpc, 'Data too long.', $code, $caller, $previous),
            'DATE_EMPTY' => new self($rpc, 'Date empty.', $code, $caller, $previous),
            'DC_ID_INVALID' => new \danog\MadelineProto\RPCError\DcIdInvalidError($code, $caller, $previous),
            'DH_G_A_INVALID' => new self($rpc, 'g_a invalid.', $code, $caller, $previous),
            'DOCUMENT_INVALID' => new self($rpc, 'The specified document is invalid.', $code, $caller, $previous),
            'EMAIL_HASH_EXPIRED' => new self($rpc, 'Email hash expired.', $code, $caller, $previous),
            'EMAIL_INVALID' => new self($rpc, 'The specified email is invalid.', $code, $caller, $previous),
            'EMAIL_NOT_SETUP' => new self($rpc, 'In order to change the login email with emailVerifyPurposeLoginChange, an existing login email must already be set using emailVerifyPurposeLoginSetup.', $code, $caller, $previous),
            'EMAIL_UNCONFIRMED' => new self($rpc, 'Email unconfirmed.', $code, $caller, $previous),
            'EMAIL_VERIFY_EXPIRED' => new self($rpc, 'The verification email has expired.', $code, $caller, $previous),
            'EMOJI_INVALID' => new self($rpc, 'The specified theme emoji is valid.', $code, $caller, $previous),
            'EMOJI_MARKUP_INVALID' => new self($rpc, 'The specified `video_emoji_markup` was invalid.', $code, $caller, $previous),
            'EMOJI_NOT_MODIFIED' => new self($rpc, 'The theme wasn\'t changed.', $code, $caller, $previous),
            'EMOTICON_EMPTY' => new self($rpc, 'The emoji is empty.', $code, $caller, $previous),
            'EMOTICON_INVALID' => new self($rpc, 'The specified emoji is invalid.', $code, $caller, $previous),
            'EMOTICON_STICKERPACK_MISSING' => new self($rpc, 'inputStickerSetDice.emoji cannot be empty.', $code, $caller, $previous),
            'ENCRYPTED_MESSAGE_INVALID' => new self($rpc, 'Encrypted message invalid.', $code, $caller, $previous),
            'ENCRYPTION_ALREADY_ACCEPTED' => new \danog\MadelineProto\RPCError\EncryptionAlreadyAcceptedError($code, $caller, $previous),
            'ENCRYPTION_ALREADY_DECLINED' => new \danog\MadelineProto\RPCError\EncryptionAlreadyDeclinedError($code, $caller, $previous),
            'ENCRYPTION_DECLINED' => new \danog\MadelineProto\RPCError\EncryptionDeclinedError($code, $caller, $previous),
            'ENCRYPTION_ID_INVALID' => new self($rpc, 'The provided secret chat ID is invalid.', $code, $caller, $previous),
            'ENTITIES_TOO_LONG' => new self($rpc, 'You provided too many styled message entities.', $code, $caller, $previous),
            'ENTITY_BOUNDS_INVALID' => new self($rpc, 'A specified [entity offset or length](/api/entities#entity-length) is invalid, see [here &raquo;](/api/entities#entity-length) for info on how to properly compute the entity offset/length.', $code, $caller, $previous),
            'ENTITY_MENTION_USER_INVALID' => new self($rpc, 'You mentioned an invalid user.', $code, $caller, $previous),
            'ERROR_TEXT_EMPTY' => new self($rpc, 'The provided error message is empty.', $code, $caller, $previous),
            'EXPIRE_DATE_INVALID' => new self($rpc, 'The specified expiration date is invalid.', $code, $caller, $previous),
            'EXPORT_CARD_INVALID' => new self($rpc, 'Provided card is invalid.', $code, $caller, $previous),
            'EXTERNAL_URL_INVALID' => new self($rpc, 'External URL invalid.', $code, $caller, $previous),
            'FILE_CONTENT_TYPE_INVALID' => new self($rpc, 'File content-type is invalid.', $code, $caller, $previous),
            'FILE_EMTPY' => new self($rpc, 'An empty file was provided.', $code, $caller, $previous),
            'FILE_ID_INVALID' => new self($rpc, 'The provided file id is invalid.', $code, $caller, $previous),
            'FILE_PART_EMPTY' => new self($rpc, 'The provided file part is empty.', $code, $caller, $previous),
            'FILE_PART_INVALID' => new self($rpc, 'The file part number is invalid.', $code, $caller, $previous),
            'FILE_PART_LENGTH_INVALID' => new self($rpc, 'The length of a file part is invalid.', $code, $caller, $previous),
            'FILE_PART_SIZE_CHANGED' => new self($rpc, 'Provided file part size has changed.', $code, $caller, $previous),
            'FILE_PART_SIZE_INVALID' => new self($rpc, 'The provided file part size is invalid.', $code, $caller, $previous),
            'FILE_PART_TOO_BIG' => new self($rpc, 'The uploaded file part is too big.', $code, $caller, $previous),
            'FILE_PARTS_INVALID' => new self($rpc, 'The number of file parts is invalid.', $code, $caller, $previous),
            'FILE_REFERENCE_EMPTY' => new self($rpc, 'An empty [file reference](https://core.telegram.org/api/file_reference) was specified.', $code, $caller, $previous),
            'FILE_REFERENCE_EXPIRED' => new \danog\MadelineProto\RPCError\FileReferenceExpiredError($code, $caller, $previous),
            'FILE_REFERENCE_INVALID' => new self($rpc, 'The specified [file reference](https://core.telegram.org/api/file_reference) is invalid.', $code, $caller, $previous),
            'FILE_TITLE_EMPTY' => new self($rpc, 'An empty file title was specified.', $code, $caller, $previous),
            'FILE_TOKEN_INVALID' => new \danog\MadelineProto\RPCError\FileTokenInvalidError($code, $caller, $previous),
            'FILTER_ID_INVALID' => new self($rpc, 'The specified filter ID is invalid.', $code, $caller, $previous),
            'FILTER_INCLUDE_EMPTY' => new self($rpc, 'The include_peers vector of the filter is empty.', $code, $caller, $previous),
            'FILTER_NOT_SUPPORTED' => new self($rpc, 'The specified filter cannot be used in this context.', $code, $caller, $previous),
            'FILTER_TITLE_EMPTY' => new self($rpc, 'The title field of the filter is empty.', $code, $caller, $previous),
            'FIRSTNAME_INVALID' => new self($rpc, 'The first name is invalid.', $code, $caller, $previous),
            'FOLDER_ID_EMPTY' => new self($rpc, 'An empty folder ID was specified.', $code, $caller, $previous),
            'FOLDER_ID_INVALID' => new self($rpc, 'Invalid folder ID.', $code, $caller, $previous),
            'FORUM_ENABLED' => new self($rpc, 'You can\'t execute the specified action because the group is a [forum](https://core.telegram.org/api/forum), disable forum functionality to continue.', $code, $caller, $previous),
            'FRESH_CHANGE_ADMINS_FORBIDDEN' => new self($rpc, 'You were just elected admin, you can\'t add or modify other admins yet.', $code, $caller, $previous),
            'FROM_MESSAGE_BOT_DISABLED' => new \danog\MadelineProto\RPCError\FromMessageBotDisabledError($code, $caller, $previous),
            'FROM_PEER_INVALID' => new self($rpc, 'The specified from_id is invalid.', $code, $caller, $previous),
            'GAME_BOT_INVALID' => new self($rpc, 'Bots can\'t send another bot\'s game.', $code, $caller, $previous),
            'GENERAL_MODIFY_ICON_FORBIDDEN' => new self($rpc, 'You can\'t modify the icon of the "General" topic.', $code, $caller, $previous),
            'GEO_POINT_INVALID' => new self($rpc, 'Invalid geoposition provided.', $code, $caller, $previous),
            'GIF_CONTENT_TYPE_INVALID' => new self($rpc, 'GIF content-type invalid.', $code, $caller, $previous),
            'GIF_ID_INVALID' => new self($rpc, 'The provided GIF ID is invalid.', $code, $caller, $previous),
            'GIFT_SLUG_EXPIRED' => new self($rpc, 'The specified gift slug has expired.', $code, $caller, $previous),
            'GIFT_SLUG_INVALID' => new self($rpc, 'The specified slug is invalid.', $code, $caller, $previous),
            'GRAPH_EXPIRED_RELOAD' => new self($rpc, 'This graph has expired, please obtain a new graph token.', $code, $caller, $previous),
            'GRAPH_INVALID_RELOAD' => new self($rpc, 'Invalid graph token provided, please reload the stats and provide the updated token.', $code, $caller, $previous),
            'GRAPH_OUTDATED_RELOAD' => new self($rpc, 'The graph is outdated, please get a new async token using stats.getBroadcastStats.', $code, $caller, $previous),
            'GROUPCALL_ALREADY_DISCARDED' => new self($rpc, 'The group call was already discarded.', $code, $caller, $previous),
            'GROUPCALL_FORBIDDEN' => new self($rpc, 'The group call has already ended.', $code, $caller, $previous),
            'GROUPCALL_INVALID' => new self($rpc, 'The specified group call is invalid.', $code, $caller, $previous),
            'GROUPCALL_JOIN_MISSING' => new self($rpc, 'You haven\'t joined this group call.', $code, $caller, $previous),
            'GROUPCALL_NOT_MODIFIED' => new self($rpc, 'Group call settings weren\'t modified.', $code, $caller, $previous),
            'GROUPCALL_SSRC_DUPLICATE_MUCH' => new self($rpc, 'The app needs to retry joining the group call with a new SSRC value.', $code, $caller, $previous),
            'GROUPED_MEDIA_INVALID' => new self($rpc, 'Invalid grouped media.', $code, $caller, $previous),
            'HASH_INVALID' => new self($rpc, 'The provided hash is invalid.', $code, $caller, $previous),
            'HIDE_REQUESTER_MISSING' => new self($rpc, 'The join request was missing or was already handled.', $code, $caller, $previous),
            'IMAGE_PROCESS_FAILED' => new \danog\MadelineProto\RPCError\ImageProcessFailedError($code, $caller, $previous),
            'IMPORT_FILE_INVALID' => new self($rpc, 'The specified chat export file is invalid.', $code, $caller, $previous),
            'IMPORT_FORMAT_UNRECOGNIZED' => new self($rpc, 'The specified chat export file was exported from an unsupported chat app.', $code, $caller, $previous),
            'IMPORT_ID_INVALID' => new self($rpc, 'The specified import ID is invalid.', $code, $caller, $previous),
            'IMPORT_TOKEN_INVALID' => new self($rpc, 'The specified token is invalid.', $code, $caller, $previous),
            'INLINE_RESULT_EXPIRED' => new self($rpc, 'The inline query expired.', $code, $caller, $previous),
            'INPUT_CHATLIST_INVALID' => new self($rpc, 'The specified folder is invalid.', $code, $caller, $previous),
            'INPUT_FILTER_INVALID' => new self($rpc, 'The specified filter is invalid.', $code, $caller, $previous),
            'INPUT_TEXT_EMPTY' => new self($rpc, 'The specified text is empty.', $code, $caller, $previous),
            'INPUT_TEXT_TOO_LONG' => new self($rpc, 'The specified text is too long.', $code, $caller, $previous),
            'INPUT_USER_DEACTIVATED' => new \danog\MadelineProto\RPCError\InputUserDeactivatedError($code, $caller, $previous),
            'INVITE_FORBIDDEN_WITH_JOINAS' => new self($rpc, 'If the user has anonymously joined a group call as a channel, they can\'t invite other users to the group call because that would cause deanonymization, because the invite would be sent using the original user ID, not the anonymized channel ID.', $code, $caller, $previous),
            'INVITE_HASH_EMPTY' => new self($rpc, 'The invite hash is empty.', $code, $caller, $previous),
            'INVITE_HASH_EXPIRED' => new self($rpc, 'The invite link has expired.', $code, $caller, $previous),
            'INVITE_HASH_INVALID' => new self($rpc, 'The invite hash is invalid.', $code, $caller, $previous),
            'INVITE_REQUEST_SENT' => new self($rpc, 'You have successfully requested to join this chat or channel.', $code, $caller, $previous),
            'INVITE_REVOKED_MISSING' => new self($rpc, 'The specified invite link was already revoked or is invalid.', $code, $caller, $previous),
            'INVITE_SLUG_EMPTY' => new self($rpc, 'The specified invite slug is empty.', $code, $caller, $previous),
            'INVITE_SLUG_EXPIRED' => new self($rpc, 'The specified chat folder link has expired.', $code, $caller, $previous),
            'INVITES_TOO_MUCH' => new self($rpc, 'The maximum number of per-folder invites specified by the `chatlist_invites_limit_default`/`chatlist_invites_limit_premium` [client configuration parameters &raquo;](/api/config#chatlist-invites-limit-default) was reached.', $code, $caller, $previous),
            'INVOICE_PAYLOAD_INVALID' => new self($rpc, 'The specified invoice payload is invalid.', $code, $caller, $previous),
            'JOIN_AS_PEER_INVALID' => new self($rpc, 'The specified peer cannot be used to join a group call.', $code, $caller, $previous),
            'LANG_CODE_INVALID' => new self($rpc, 'The specified language code is invalid.', $code, $caller, $previous),
            'LANG_CODE_NOT_SUPPORTED' => new self($rpc, 'The specified language code is not supported.', $code, $caller, $previous),
            'LANG_PACK_INVALID' => new self($rpc, 'The provided language pack is invalid.', $code, $caller, $previous),
            'LASTNAME_INVALID' => new self($rpc, 'The last name is invalid.', $code, $caller, $previous),
            'LIMIT_INVALID' => new self($rpc, 'The provided limit is invalid.', $code, $caller, $previous),
            'LINK_NOT_MODIFIED' => new self($rpc, 'Discussion link not modified.', $code, $caller, $previous),
            'LOCATION_INVALID' => new self($rpc, 'The provided location is invalid.', $code, $caller, $previous),
            'MAX_DATE_INVALID' => new self($rpc, 'The specified maximum date is invalid.', $code, $caller, $previous),
            'MAX_ID_INVALID' => new self($rpc, 'The provided max ID is invalid.', $code, $caller, $previous),
            'MAX_QTS_INVALID' => new self($rpc, 'The specified max_qts is invalid.', $code, $caller, $previous),
            'MD5_CHECKSUM_INVALID' => new self($rpc, 'The MD5 checksums do not match.', $code, $caller, $previous),
            'MEDIA_CAPTION_TOO_LONG' => new self($rpc, 'The caption is too long.', $code, $caller, $previous),
            'MEDIA_EMPTY' => new self($rpc, 'The provided media object is invalid.', $code, $caller, $previous),
            'MEDIA_FILE_INVALID' => new self($rpc, 'The specified media file is invalid.', $code, $caller, $previous),
            'MEDIA_GROUPED_INVALID' => new self($rpc, 'You tried to send media of different types in an album.', $code, $caller, $previous),
            'MEDIA_INVALID' => new self($rpc, 'Media invalid.', $code, $caller, $previous),
            'MEDIA_NEW_INVALID' => new self($rpc, 'The new media is invalid.', $code, $caller, $previous),
            'MEDIA_PREV_INVALID' => new self($rpc, 'Previous media invalid.', $code, $caller, $previous),
            'MEDIA_TTL_INVALID' => new self($rpc, 'The specified media TTL is invalid.', $code, $caller, $previous),
            'MEDIA_TYPE_INVALID' => new self($rpc, 'The specified media type cannot be used in stories.', $code, $caller, $previous),
            'MEDIA_VIDEO_STORY_MISSING' => new self($rpc, 'A non-story video cannot be repubblished as a story (emitted when trying to resend a non-story video as a story using inputDocument).', $code, $caller, $previous),
            'MEGAGROUP_GEO_REQUIRED' => new self($rpc, 'This method can only be invoked on a geogroup.', $code, $caller, $previous),
            'MEGAGROUP_ID_INVALID' => new self($rpc, 'Invalid supergroup ID.', $code, $caller, $previous),
            'MEGAGROUP_PREHISTORY_HIDDEN' => new self($rpc, 'Group with hidden history for new members can\'t be set as discussion groups.', $code, $caller, $previous),
            'MEGAGROUP_REQUIRED' => new self($rpc, 'You can only use this method on a supergroup.', $code, $caller, $previous),
            'MESSAGE_EDIT_TIME_EXPIRED' => new self($rpc, 'You can\'t edit this message anymore, too much time has passed since its creation.', $code, $caller, $previous),
            'MESSAGE_EMPTY' => new self($rpc, 'The provided message is empty.', $code, $caller, $previous),
            'MESSAGE_ID_INVALID' => new self($rpc, 'The provided message id is invalid.', $code, $caller, $previous),
            'MESSAGE_IDS_EMPTY' => new self($rpc, 'No message ids were provided.', $code, $caller, $previous),
            'MESSAGE_NOT_MODIFIED' => new self($rpc, 'The provided message data is identical to the previous message data, the message wasn\'t modified.', $code, $caller, $previous),
            'MESSAGE_POLL_CLOSED' => new self($rpc, 'Poll closed.', $code, $caller, $previous),
            'MESSAGE_TOO_LONG' => new self($rpc, 'The provided message is too long.', $code, $caller, $previous),
            'METHOD_INVALID' => new self($rpc, 'The specified method is invalid.', $code, $caller, $previous),
            'MIN_DATE_INVALID' => new self($rpc, 'The specified minimum date is invalid.', $code, $caller, $previous),
            'MSG_ID_INVALID' => new \danog\MadelineProto\RPCError\MsgIdInvalidError($code, $caller, $previous),
            'MSG_TOO_OLD' => new self($rpc, '[`chat_read_mark_expire_period` seconds](https://core.telegram.org/api/config#chat-read-mark-expire-period) have passed since the message was sent, read receipts were deleted.', $code, $caller, $previous),
            'MSG_WAIT_FAILED' => new self($rpc, 'A waiting call returned an error.', $code, $caller, $previous),
            'MULTI_MEDIA_TOO_LONG' => new self($rpc, 'Too many media files for album.', $code, $caller, $previous),
            'NEW_SALT_INVALID' => new self($rpc, 'The new salt is invalid.', $code, $caller, $previous),
            'NEW_SETTINGS_EMPTY' => new self($rpc, 'No password is set on the current account, and no new password was specified in `new_settings`.', $code, $caller, $previous),
            'NEW_SETTINGS_INVALID' => new self($rpc, 'The new password settings are invalid.', $code, $caller, $previous),
            'NEXT_OFFSET_INVALID' => new self($rpc, 'The specified offset is longer than 64 bytes.', $code, $caller, $previous),
            'OFFSET_INVALID' => new self($rpc, 'The provided offset is invalid.', $code, $caller, $previous),
            'OFFSET_PEER_ID_INVALID' => new self($rpc, 'The provided offset peer is invalid.', $code, $caller, $previous),
            'OPTION_INVALID' => new self($rpc, 'Invalid option selected.', $code, $caller, $previous),
            'OPTIONS_TOO_MUCH' => new self($rpc, 'Too many options provided.', $code, $caller, $previous),
            'ORDER_INVALID' => new self($rpc, 'The specified username order is invalid.', $code, $caller, $previous),
            'PACK_SHORT_NAME_INVALID' => new self($rpc, 'Short pack name invalid.', $code, $caller, $previous),
            'PACK_SHORT_NAME_OCCUPIED' => new self($rpc, 'A stickerpack with this name already exists.', $code, $caller, $previous),
            'PACK_TITLE_INVALID' => new self($rpc, 'The stickerpack title is invalid.', $code, $caller, $previous),
            'PARTICIPANT_ID_INVALID' => new self($rpc, 'The specified participant ID is invalid.', $code, $caller, $previous),
            'PARTICIPANT_JOIN_MISSING' => new self($rpc, 'Trying to enable a presentation, when the user hasn\'t joined the Video Chat with [phone.joinGroupCall](https://core.telegram.org/method/phone.joinGroupCall).', $code, $caller, $previous),
            'PARTICIPANT_VERSION_OUTDATED' => new self($rpc, 'The other participant does not use an up to date telegram client with support for calls.', $code, $caller, $previous),
            'PARTICIPANTS_TOO_FEW' => new self($rpc, 'Not enough participants.', $code, $caller, $previous),
            'PASSWORD_EMPTY' => new self($rpc, 'The provided password is empty.', $code, $caller, $previous),
            'PASSWORD_HASH_INVALID' => new \danog\MadelineProto\RPCError\PasswordHashInvalidError($code, $caller, $previous),
            'PASSWORD_MISSING' => new self($rpc, 'You must enable 2FA in order to transfer ownership of a channel.', $code, $caller, $previous),
            'PASSWORD_RECOVERY_EXPIRED' => new self($rpc, 'The recovery code has expired.', $code, $caller, $previous),
            'PASSWORD_RECOVERY_NA' => new self($rpc, 'No email was set, can\'t recover password via email.', $code, $caller, $previous),
            'PASSWORD_REQUIRED' => new self($rpc, 'A [2FA password](https://core.telegram.org/api/srp) must be configured to use Telegram Passport.', $code, $caller, $previous),
            'PAYMENT_PROVIDER_INVALID' => new self($rpc, 'The specified payment provider is invalid.', $code, $caller, $previous),
            'PEER_HISTORY_EMPTY' => new self($rpc, 'You can\'t pin an empty chat with a user.', $code, $caller, $previous),
            'PEER_ID_INVALID' => new \danog\MadelineProto\RPCError\PeerIdInvalidError($code, $caller, $previous),
            'PEER_ID_NOT_SUPPORTED' => new self($rpc, 'The provided peer ID is not supported.', $code, $caller, $previous),
            'PEERS_LIST_EMPTY' => new self($rpc, 'The specified list of peers is empty.', $code, $caller, $previous),
            'PERSISTENT_TIMESTAMP_EMPTY' => new self($rpc, 'Persistent timestamp empty.', $code, $caller, $previous),
            'PERSISTENT_TIMESTAMP_INVALID' => new self($rpc, 'Persistent timestamp invalid.', $code, $caller, $previous),
            'PHONE_CODE_EMPTY' => new self($rpc, 'phone_code is missing.', $code, $caller, $previous),
            'PHONE_CODE_EXPIRED' => new self($rpc, 'The phone code you provided has expired.', $code, $caller, $previous),
            'PHONE_CODE_HASH_EMPTY' => new self($rpc, 'phone_code_hash is missing.', $code, $caller, $previous),
            'PHONE_CODE_INVALID' => new self($rpc, 'The provided phone code is invalid.', $code, $caller, $previous),
            'PHONE_HASH_EXPIRED' => new self($rpc, 'An invalid or expired `phone_code_hash` was provided.', $code, $caller, $previous),
            'PHONE_NOT_OCCUPIED' => new self($rpc, 'No user is associated to the specified phone number.', $code, $caller, $previous),
            'PHONE_NUMBER_APP_SIGNUP_FORBIDDEN' => new self($rpc, 'You can\'t sign up using this app.', $code, $caller, $previous),
            'PHONE_NUMBER_BANNED' => new self($rpc, 'The provided phone number is banned from telegram.', $code, $caller, $previous),
            'PHONE_NUMBER_FLOOD' => new self($rpc, 'You asked for the code too many times.', $code, $caller, $previous),
            'PHONE_NUMBER_INVALID' => new self($rpc, 'The phone number is invalid.', $code, $caller, $previous),
            'PHONE_NUMBER_OCCUPIED' => new self($rpc, 'The phone number is already in use.', $code, $caller, $previous),
            'PHONE_NUMBER_UNOCCUPIED' => new self($rpc, 'The phone number is not yet being used.', $code, $caller, $previous),
            'PHONE_PASSWORD_PROTECTED' => new self($rpc, 'This phone is password protected.', $code, $caller, $previous),
            'PHOTO_CONTENT_TYPE_INVALID' => new self($rpc, 'Photo mime-type invalid.', $code, $caller, $previous),
            'PHOTO_CONTENT_URL_EMPTY' => new self($rpc, 'Photo URL invalid.', $code, $caller, $previous),
            'PHOTO_CROP_FILE_MISSING' => new self($rpc, 'Photo crop file missing.', $code, $caller, $previous),
            'PHOTO_CROP_SIZE_SMALL' => new self($rpc, 'Photo is too small.', $code, $caller, $previous),
            'PHOTO_EXT_INVALID' => new self($rpc, 'The extension of the photo is invalid.', $code, $caller, $previous),
            'PHOTO_FILE_MISSING' => new self($rpc, 'Profile photo file missing.', $code, $caller, $previous),
            'PHOTO_ID_INVALID' => new self($rpc, 'Photo ID invalid.', $code, $caller, $previous),
            'PHOTO_INVALID' => new self($rpc, 'Photo invalid.', $code, $caller, $previous),
            'PHOTO_INVALID_DIMENSIONS' => new self($rpc, 'The photo dimensions are invalid.', $code, $caller, $previous),
            'PHOTO_SAVE_FILE_INVALID' => new self($rpc, 'Internal issues, try again later.', $code, $caller, $previous),
            'PHOTO_THUMB_URL_EMPTY' => new self($rpc, 'Photo thumbnail URL is empty.', $code, $caller, $previous),
            'PIN_RESTRICTED' => new self($rpc, 'You can\'t pin messages.', $code, $caller, $previous),
            'PINNED_DIALOGS_TOO_MUCH' => new \danog\MadelineProto\RPCError\PinnedDialogsTooMuchError($code, $caller, $previous),
            'POLL_ANSWER_INVALID' => new self($rpc, 'One of the poll answers is not acceptable.', $code, $caller, $previous),
            'POLL_ANSWERS_INVALID' => new self($rpc, 'Invalid poll answers were provided.', $code, $caller, $previous),
            'POLL_OPTION_DUPLICATE' => new \danog\MadelineProto\RPCError\PollOptionDuplicateError($code, $caller, $previous),
            'POLL_OPTION_INVALID' => new self($rpc, 'Invalid poll option provided.', $code, $caller, $previous),
            'POLL_QUESTION_INVALID' => new self($rpc, 'One of the poll questions is not acceptable.', $code, $caller, $previous),
            'PREMIUM_ACCOUNT_REQUIRED' => new \danog\MadelineProto\RPCError\PremiumAccountRequiredError($code, $caller, $previous),
            'PRIVACY_KEY_INVALID' => new self($rpc, 'The privacy key is invalid.', $code, $caller, $previous),
            'PRIVACY_TOO_LONG' => new self($rpc, 'Too many privacy rules were specified, the current limit is 1000.', $code, $caller, $previous),
            'PRIVACY_VALUE_INVALID' => new self($rpc, 'The specified privacy rule combination is invalid.', $code, $caller, $previous),
            'PUBLIC_KEY_REQUIRED' => new self($rpc, 'A public key is required.', $code, $caller, $previous),
            'QUERY_ID_EMPTY' => new self($rpc, 'The query ID is empty.', $code, $caller, $previous),
            'QUERY_ID_INVALID' => new self($rpc, 'The query ID is invalid.', $code, $caller, $previous),
            'QUERY_TOO_SHORT' => new self($rpc, 'The query string is too short.', $code, $caller, $previous),
            'QUIZ_ANSWER_MISSING' => new self($rpc, 'You can forward a quiz while hiding the original author only after choosing an option in the quiz.', $code, $caller, $previous),
            'QUIZ_CORRECT_ANSWER_INVALID' => new self($rpc, 'An invalid value was provided to the correct_answers field.', $code, $caller, $previous),
            'QUIZ_CORRECT_ANSWERS_EMPTY' => new self($rpc, 'No correct quiz answer was specified.', $code, $caller, $previous),
            'QUIZ_CORRECT_ANSWERS_TOO_MUCH' => new \danog\MadelineProto\RPCError\QuizCorrectAnswersTooMuchError($code, $caller, $previous),
            'QUIZ_MULTIPLE_INVALID' => new self($rpc, 'Quizzes can\'t have the multiple_choice flag set!', $code, $caller, $previous),
            'RANDOM_ID_EMPTY' => new self($rpc, 'Random ID empty.', $code, $caller, $previous),
            'RANDOM_ID_INVALID' => new self($rpc, 'A provided random ID is invalid.', $code, $caller, $previous),
            'RANDOM_LENGTH_INVALID' => new self($rpc, 'Random length invalid.', $code, $caller, $previous),
            'RANGES_INVALID' => new self($rpc, 'Invalid range provided.', $code, $caller, $previous),
            'REACTION_EMPTY' => new self($rpc, 'Empty reaction provided.', $code, $caller, $previous),
            'REACTION_INVALID' => new self($rpc, 'The specified reaction is invalid.', $code, $caller, $previous),
            'REACTIONS_TOO_MANY' => new self($rpc, 'The message already has exactly `reactions_uniq_max` reaction emojis, you can\'t react with a new emoji, see [the docs for more info &raquo;](/api/config#client-configuration).', $code, $caller, $previous),
            'REPLY_MARKUP_BUY_EMPTY' => new self($rpc, 'Reply markup for buy button empty.', $code, $caller, $previous),
            'REPLY_MARKUP_INVALID' => new self($rpc, 'The provided reply markup is invalid.', $code, $caller, $previous),
            'REPLY_MARKUP_TOO_LONG' => new self($rpc, 'The specified reply_markup is too long.', $code, $caller, $previous),
            'REPLY_MESSAGE_ID_INVALID' => new self($rpc, 'The specified reply-to message ID is invalid.', $code, $caller, $previous),
            'REPLY_TO_INVALID' => new self($rpc, 'The specified `reply_to` field is invalid.', $code, $caller, $previous),
            'REPLY_TO_USER_INVALID' => new self($rpc, 'The replied-to user is invalid.', $code, $caller, $previous),
            'RESET_REQUEST_MISSING' => new self($rpc, 'No password reset is in progress.', $code, $caller, $previous),
            'RESULT_ID_DUPLICATE' => new self($rpc, 'You provided a duplicate result ID.', $code, $caller, $previous),
            'RESULT_ID_EMPTY' => new self($rpc, 'Result ID empty.', $code, $caller, $previous),
            'RESULT_ID_INVALID' => new self($rpc, 'One of the specified result IDs is invalid.', $code, $caller, $previous),
            'RESULT_TYPE_INVALID' => new self($rpc, 'Result type invalid.', $code, $caller, $previous),
            'RESULTS_TOO_MUCH' => new self($rpc, 'Too many results were provided.', $code, $caller, $previous),
            'REVOTE_NOT_ALLOWED' => new self($rpc, 'You cannot change your vote.', $code, $caller, $previous),
            'RIGHTS_NOT_MODIFIED' => new self($rpc, 'The new admin rights are equal to the old rights, no change was made.', $code, $caller, $previous),
            'RSA_DECRYPT_FAILED' => new self($rpc, 'Internal RSA decryption failed.', $code, $caller, $previous),
            'SCHEDULE_BOT_NOT_ALLOWED' => new \danog\MadelineProto\RPCError\ScheduleBotNotAllowedError($code, $caller, $previous),
            'SCHEDULE_DATE_INVALID' => new self($rpc, 'Invalid schedule date provided.', $code, $caller, $previous),
            'SCHEDULE_DATE_TOO_LATE' => new \danog\MadelineProto\RPCError\ScheduleDateTooLateError($code, $caller, $previous),
            'SCHEDULE_STATUS_PRIVATE' => new \danog\MadelineProto\RPCError\ScheduleStatusPrivateError($code, $caller, $previous),
            'SCHEDULE_TOO_MUCH' => new \danog\MadelineProto\RPCError\ScheduleTooMuchError($code, $caller, $previous),
            'SCORE_INVALID' => new self($rpc, 'The specified game score is invalid.', $code, $caller, $previous),
            'SEARCH_QUERY_EMPTY' => new self($rpc, 'The search query is empty.', $code, $caller, $previous),
            'SEARCH_WITH_LINK_NOT_SUPPORTED' => new self($rpc, 'You cannot provide a search query and an invite link at the same time.', $code, $caller, $previous),
            'SECONDS_INVALID' => new self($rpc, 'Invalid duration provided.', $code, $caller, $previous),
            'SEND_AS_PEER_INVALID' => new self($rpc, 'You can\'t send messages as the specified peer.', $code, $caller, $previous),
            'SEND_MESSAGE_MEDIA_INVALID' => new self($rpc, 'Invalid media provided.', $code, $caller, $previous),
            'SEND_MESSAGE_TYPE_INVALID' => new self($rpc, 'The message type is invalid.', $code, $caller, $previous),
            'SETTINGS_INVALID' => new self($rpc, 'Invalid settings were provided.', $code, $caller, $previous),
            'SHA256_HASH_INVALID' => new self($rpc, 'The provided SHA256 hash is invalid.', $code, $caller, $previous),
            'SHORT_NAME_INVALID' => new self($rpc, 'The specified short name is invalid.', $code, $caller, $previous),
            'SHORT_NAME_OCCUPIED' => new self($rpc, 'The specified short name is already in use.', $code, $caller, $previous),
            'SLOTS_EMPTY' => new self($rpc, 'The specified slot list is empty.', $code, $caller, $previous),
            'SLOWMODE_MULTI_MSGS_DISABLED' => new self($rpc, 'Slowmode is enabled, you cannot forward multiple messages to this group.', $code, $caller, $previous),
            'SLUG_INVALID' => new self($rpc, 'The specified invoice slug is invalid.', $code, $caller, $previous),
            'SMS_CODE_CREATE_FAILED' => new self($rpc, 'An error occurred while creating the SMS code.', $code, $caller, $previous),
            'SRP_ID_INVALID' => new self($rpc, 'Invalid SRP ID provided.', $code, $caller, $previous),
            'SRP_PASSWORD_CHANGED' => new self($rpc, 'Password has changed.', $code, $caller, $previous),
            'START_PARAM_EMPTY' => new self($rpc, 'The start parameter is empty.', $code, $caller, $previous),
            'START_PARAM_INVALID' => new self($rpc, 'Start parameter invalid.', $code, $caller, $previous),
            'START_PARAM_TOO_LONG' => new self($rpc, 'Start parameter is too long.', $code, $caller, $previous),
            'STICKER_DOCUMENT_INVALID' => new self($rpc, 'The specified sticker document is invalid.', $code, $caller, $previous),
            'STICKER_EMOJI_INVALID' => new self($rpc, 'Sticker emoji invalid.', $code, $caller, $previous),
            'STICKER_FILE_INVALID' => new self($rpc, 'Sticker file invalid.', $code, $caller, $previous),
            'STICKER_GIF_DIMENSIONS' => new self($rpc, 'The specified video sticker has invalid dimensions.', $code, $caller, $previous),
            'STICKER_ID_INVALID' => new self($rpc, 'The provided sticker ID is invalid.', $code, $caller, $previous),
            'STICKER_INVALID' => new self($rpc, 'The provided sticker is invalid.', $code, $caller, $previous),
            'STICKER_MIME_INVALID' => new self($rpc, 'The specified sticker MIME type is invalid.', $code, $caller, $previous),
            'STICKER_PNG_DIMENSIONS' => new self($rpc, 'Sticker png dimensions invalid.', $code, $caller, $previous),
            'STICKER_PNG_NOPNG' => new self($rpc, 'One of the specified stickers is not a valid PNG file.', $code, $caller, $previous),
            'STICKER_TGS_NODOC' => new self($rpc, 'You must send the animated sticker as a document.', $code, $caller, $previous),
            'STICKER_TGS_NOTGS' => new self($rpc, 'Invalid TGS sticker provided.', $code, $caller, $previous),
            'STICKER_THUMB_PNG_NOPNG' => new self($rpc, 'Incorrect stickerset thumb file provided, PNG / WEBP expected.', $code, $caller, $previous),
            'STICKER_THUMB_TGS_NOTGS' => new self($rpc, 'Incorrect stickerset TGS thumb file provided.', $code, $caller, $previous),
            'STICKER_VIDEO_BIG' => new self($rpc, 'The specified video sticker is too big.', $code, $caller, $previous),
            'STICKER_VIDEO_NODOC' => new self($rpc, 'You must send the video sticker as a document.', $code, $caller, $previous),
            'STICKER_VIDEO_NOWEBM' => new self($rpc, 'The specified video sticker is not in webm format.', $code, $caller, $previous),
            'STICKERPACK_STICKERS_TOO_MUCH' => new self($rpc, 'There are too many stickers in this stickerpack, you can\'t add any more.', $code, $caller, $previous),
            'STICKERS_EMPTY' => new self($rpc, 'No sticker provided.', $code, $caller, $previous),
            'STICKERS_TOO_MUCH' => new self($rpc, 'There are too many stickers in this stickerpack, you can\'t add any more.', $code, $caller, $previous),
            'STICKERSET_INVALID' => new self($rpc, 'The provided sticker set is invalid.', $code, $caller, $previous),
            'STORIES_NEVER_CREATED' => new self($rpc, 'This peer hasn\'t ever posted any stories.', $code, $caller, $previous),
            'STORIES_TOO_MUCH' => new self($rpc, 'You have hit the maximum active stories limit as specified by the [`story_expiring_limit_*` client configuration parameters](https://core.telegram.org/api/config#story-expiring-limit-default): you should buy a [Premium](/api/premium) subscription, delete an active story, or wait for the oldest story to expire.', $code, $caller, $previous),
            'STORY_ID_EMPTY' => new self($rpc, 'You specified no story IDs.', $code, $caller, $previous),
            'STORY_ID_INVALID' => new self($rpc, 'The specified story ID is invalid.', $code, $caller, $previous),
            'STORY_NOT_MODIFIED' => new self($rpc, 'The new story information you passed is equal to the previous story information, thus it wasn\'t modified.', $code, $caller, $previous),
            'STORY_PERIOD_INVALID' => new self($rpc, 'The specified story period is invalid for this account.', $code, $caller, $previous),
            'SWITCH_PM_TEXT_EMPTY' => new self($rpc, 'The switch_pm.text field was empty.', $code, $caller, $previous),
            'TAKEOUT_INVALID' => new self($rpc, 'The specified takeout ID is invalid.', $code, $caller, $previous),
            'TAKEOUT_REQUIRED' => new self($rpc, 'A [takeout](https://core.telegram.org/api/takeout) session needs to be initialized first, [see here &raquo; for more info](/api/takeout).', $code, $caller, $previous),
            'TASK_ALREADY_EXISTS' => new self($rpc, 'An email reset was already requested.', $code, $caller, $previous),
            'TEMP_AUTH_KEY_ALREADY_BOUND' => new self($rpc, 'The passed temporary key is already bound to another **perm_auth_key_id**.', $code, $caller, $previous),
            'TEMP_AUTH_KEY_EMPTY' => new self($rpc, 'No temporary auth key provided.', $code, $caller, $previous),
            'THEME_FILE_INVALID' => new self($rpc, 'Invalid theme file provided.', $code, $caller, $previous),
            'THEME_FORMAT_INVALID' => new self($rpc, 'Invalid theme format provided.', $code, $caller, $previous),
            'THEME_INVALID' => new self($rpc, 'Invalid theme provided.', $code, $caller, $previous),
            'THEME_MIME_INVALID' => new self($rpc, 'The theme\'s MIME type is invalid.', $code, $caller, $previous),
            'THEME_TITLE_INVALID' => new self($rpc, 'The specified theme title is invalid.', $code, $caller, $previous),
            'TITLE_INVALID' => new self($rpc, 'The specified stickerpack title is invalid.', $code, $caller, $previous),
            'TMP_PASSWORD_DISABLED' => new self($rpc, 'The temporary password is disabled.', $code, $caller, $previous),
            'TO_LANG_INVALID' => new self($rpc, 'The specified destination language is invalid.', $code, $caller, $previous),
            'TOKEN_EMPTY' => new self($rpc, 'The specified token is empty.', $code, $caller, $previous),
            'TOKEN_INVALID' => new self($rpc, 'The provided token is invalid.', $code, $caller, $previous),
            'TOKEN_TYPE_INVALID' => new self($rpc, 'The specified token type is invalid.', $code, $caller, $previous),
            'TOPIC_CLOSE_SEPARATELY' => new self($rpc, 'The `close` flag cannot be provided together with any of the other flags.', $code, $caller, $previous),
            'TOPIC_CLOSED' => new \danog\MadelineProto\RPCError\TopicClosedError($code, $caller, $previous),
            'TOPIC_DELETED' => new \danog\MadelineProto\RPCError\TopicDeletedError($code, $caller, $previous),
            'TOPIC_HIDE_SEPARATELY' => new self($rpc, 'The `hide` flag cannot be provided together with any of the other flags.', $code, $caller, $previous),
            'TOPIC_ID_INVALID' => new self($rpc, 'The specified topic ID is invalid.', $code, $caller, $previous),
            'TOPIC_NOT_MODIFIED' => new self($rpc, 'The updated topic info is equal to the current topic info, nothing was changed.', $code, $caller, $previous),
            'TOPIC_TITLE_EMPTY' => new self($rpc, 'The specified topic title is empty.', $code, $caller, $previous),
            'TOPICS_EMPTY' => new self($rpc, 'You specified no topic IDs.', $code, $caller, $previous),
            'TRANSCRIPTION_FAILED' => new self($rpc, 'Audio transcription failed.', $code, $caller, $previous),
            'TTL_DAYS_INVALID' => new self($rpc, 'The provided TTL is invalid.', $code, $caller, $previous),
            'TTL_MEDIA_INVALID' => new self($rpc, 'Invalid media Time To Live was provided.', $code, $caller, $previous),
            'TTL_PERIOD_INVALID' => new self($rpc, 'The specified TTL period is invalid.', $code, $caller, $previous),
            'TYPES_EMPTY' => new self($rpc, 'No top peer type was provided.', $code, $caller, $previous),
            'UNTIL_DATE_INVALID' => new self($rpc, 'Invalid until date provided.', $code, $caller, $previous),
            'URL_INVALID' => new self($rpc, 'Invalid URL provided.', $code, $caller, $previous),
            'USAGE_LIMIT_INVALID' => new self($rpc, 'The specified usage limit is invalid.', $code, $caller, $previous),
            'USER_ADMIN_INVALID' => new self($rpc, 'You\'re not an admin.', $code, $caller, $previous),
            'USER_ALREADY_INVITED' => new self($rpc, 'You have already invited this user.', $code, $caller, $previous),
            'USER_ALREADY_PARTICIPANT' => new self($rpc, 'The user is already in the group.', $code, $caller, $previous),
            'USER_BANNED_IN_CHANNEL' => new \danog\MadelineProto\RPCError\UserBannedInChannelError($code, $caller, $previous),
            'USER_BLOCKED' => new self($rpc, 'User blocked.', $code, $caller, $previous),
            'USER_BOT' => new self($rpc, 'Bots can only be admins in channels.', $code, $caller, $previous),
            'USER_BOT_INVALID' => new self($rpc, 'User accounts must provide the `bot` method parameter when calling this method. If there is no such method parameter, this method can only be invoked by bot accounts.', $code, $caller, $previous),
            'USER_BOT_REQUIRED' => new self($rpc, 'This method can only be called by a bot.', $code, $caller, $previous),
            'USER_CHANNELS_TOO_MUCH' => new self($rpc, 'One of the users you tried to add is already in too many channels/supergroups.', $code, $caller, $previous),
            'USER_CREATOR' => new self($rpc, 'You can\'t leave this channel, because you\'re its creator.', $code, $caller, $previous),
            'USER_ID_INVALID' => new self($rpc, 'The provided user ID is invalid.', $code, $caller, $previous),
            'USER_INVALID' => new self($rpc, 'Invalid user provided.', $code, $caller, $previous),
            'USER_IS_BLOCKED' => new \danog\MadelineProto\RPCError\UserIsBlockedError($code, $caller, $previous),
            'USER_IS_BOT' => new \danog\MadelineProto\RPCError\UserIsBotError($code, $caller, $previous),
            'USER_KICKED' => new self($rpc, 'This user was kicked from this supergroup/channel.', $code, $caller, $previous),
            'USER_NOT_MUTUAL_CONTACT' => new self($rpc, 'The provided user is not a mutual contact.', $code, $caller, $previous),
            'USER_NOT_PARTICIPANT' => new self($rpc, 'You\'re not a member of this supergroup/channel.', $code, $caller, $previous),
            'USER_PUBLIC_MISSING' => new self($rpc, 'Cannot generate a link to stories posted by a peer without a username.', $code, $caller, $previous),
            'USER_VOLUME_INVALID' => new self($rpc, 'The specified user volume is invalid.', $code, $caller, $previous),
            'USERNAME_INVALID' => new self($rpc, 'The provided username is not valid.', $code, $caller, $previous),
            'USERNAME_NOT_MODIFIED' => new self($rpc, 'The username was not modified.', $code, $caller, $previous),
            'USERNAME_NOT_OCCUPIED' => new self($rpc, 'The provided username is not occupied.', $code, $caller, $previous),
            'USERNAME_OCCUPIED' => new self($rpc, 'The provided username is already occupied.', $code, $caller, $previous),
            'USERNAME_PURCHASE_AVAILABLE' => new self($rpc, 'The specified username can be purchased on https://fragment.com.', $code, $caller, $previous),
            'USERNAMES_ACTIVE_TOO_MUCH' => new self($rpc, 'The maximum number of active usernames was reached.', $code, $caller, $previous),
            'USERPIC_UPLOAD_REQUIRED' => new self($rpc, 'You must have a profile picture to publish your geolocation.', $code, $caller, $previous),
            'USERS_TOO_FEW' => new self($rpc, 'Not enough users (to create a chat, for example).', $code, $caller, $previous),
            'USERS_TOO_MUCH' => new self($rpc, 'The maximum number of users has been exceeded (to create a chat, for example).', $code, $caller, $previous),
            'VENUE_ID_INVALID' => new self($rpc, 'The specified venue ID is invalid.', $code, $caller, $previous),
            'VIDEO_CONTENT_TYPE_INVALID' => new self($rpc, 'The video\'s content type is invalid.', $code, $caller, $previous),
            'VIDEO_FILE_INVALID' => new self($rpc, 'The specified video file is invalid.', $code, $caller, $previous),
            'VIDEO_TITLE_EMPTY' => new self($rpc, 'The specified video title is empty.', $code, $caller, $previous),
            'VOICE_MESSAGES_FORBIDDEN' => new \danog\MadelineProto\RPCError\VoiceMessagesForbiddenError($code, $caller, $previous),
            'WALLPAPER_FILE_INVALID' => new self($rpc, 'The specified wallpaper file is invalid.', $code, $caller, $previous),
            'WALLPAPER_INVALID' => new self($rpc, 'The specified wallpaper is invalid.', $code, $caller, $previous),
            'WALLPAPER_MIME_INVALID' => new self($rpc, 'The specified wallpaper MIME type is invalid.', $code, $caller, $previous),
            'WALLPAPER_NOT_FOUND' => new self($rpc, 'The specified wallpaper could not be found.', $code, $caller, $previous),
            'WC_CONVERT_URL_INVALID' => new self($rpc, 'WC convert URL invalid.', $code, $caller, $previous),
            'WEBDOCUMENT_INVALID' => new self($rpc, 'Invalid webdocument URL provided.', $code, $caller, $previous),
            'WEBDOCUMENT_MIME_INVALID' => new self($rpc, 'Invalid webdocument mime type provided.', $code, $caller, $previous),
            'WEBDOCUMENT_SIZE_TOO_BIG' => new self($rpc, 'Webdocument is too big!', $code, $caller, $previous),
            'WEBDOCUMENT_URL_INVALID' => new self($rpc, 'The specified webdocument URL is invalid.', $code, $caller, $previous),
            'WEBPAGE_CURL_FAILED' => new \danog\MadelineProto\RPCError\WebpageCurlFailedError($code, $caller, $previous),
            'WEBPAGE_MEDIA_EMPTY' => new self($rpc, 'Webpage media empty.', $code, $caller, $previous),
            'WEBPAGE_NOT_FOUND' => new \danog\MadelineProto\RPCError\WebpageNotFoundError($code, $caller, $previous),
            'WEBPAGE_URL_INVALID' => new self($rpc, 'The specified webpage `url` is invalid.', $code, $caller, $previous),
            'WEBPUSH_AUTH_INVALID' => new self($rpc, 'The specified web push authentication secret is invalid.', $code, $caller, $previous),
            'WEBPUSH_KEY_INVALID' => new self($rpc, 'The specified web push elliptic curve Diffie-Hellman public key is invalid.', $code, $caller, $previous),
            'WEBPUSH_TOKEN_INVALID' => new self($rpc, 'The specified web push token is invalid.', $code, $caller, $previous),
            'YOU_BLOCKED_USER' => new \danog\MadelineProto\RPCError\YouBlockedUserError($code, $caller, $previous),
            'ANONYMOUS_REACTIONS_DISABLED' => new self($rpc, 'Sorry, anonymous administrators cannot leave reactions or participate in polls.', $code, $caller, $previous),
            'BROADCAST_FORBIDDEN' => new self($rpc, 'Channel poll voters and reactions cannot be fetched to prevent deanonymization.', $code, $caller, $previous),
            'CHANNEL_PUBLIC_GROUP_NA' => new self($rpc, 'channel/supergroup not available.', $code, $caller, $previous),
            'CHAT_ADMIN_INVITE_REQUIRED' => new self($rpc, 'You do not have the rights to do this.', $code, $caller, $previous),
            'CHAT_GUEST_SEND_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatGuestSendForbiddenError($code, $caller, $previous),
            'CHAT_SEND_AUDIOS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendAudiosForbiddenError($code, $caller, $previous),
            'CHAT_SEND_DOCS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendDocsForbiddenError($code, $caller, $previous),
            'CHAT_SEND_GAME_FORBIDDEN' => new self($rpc, 'You can\'t send a game to this chat.', $code, $caller, $previous),
            'CHAT_SEND_GIFS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendGifsForbiddenError($code, $caller, $previous),
            'CHAT_SEND_MEDIA_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendMediaForbiddenError($code, $caller, $previous),
            'CHAT_SEND_PHOTOS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendPhotosForbiddenError($code, $caller, $previous),
            'CHAT_SEND_PLAIN_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendPlainForbiddenError($code, $caller, $previous),
            'CHAT_SEND_POLL_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendPollForbiddenError($code, $caller, $previous),
            'CHAT_SEND_STICKERS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendStickersForbiddenError($code, $caller, $previous),
            'CHAT_SEND_VIDEOS_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendVideosForbiddenError($code, $caller, $previous),
            'CHAT_SEND_VOICES_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatSendVoicesForbiddenError($code, $caller, $previous),
            'CHAT_WRITE_FORBIDDEN' => new \danog\MadelineProto\RPCError\ChatWriteForbiddenError($code, $caller, $previous),
            'EDIT_BOT_INVITE_FORBIDDEN' => new self($rpc, 'Normal users can\'t edit invites that were created by bots.', $code, $caller, $previous),
            'GROUPCALL_ALREADY_STARTED' => new self($rpc, 'The groupcall has already started, you can join directly using [phone.joinGroupCall](https://core.telegram.org/method/phone.joinGroupCall).', $code, $caller, $previous),
            'INLINE_BOT_REQUIRED' => new self($rpc, 'Only the inline bot can edit message.', $code, $caller, $previous),
            'MESSAGE_AUTHOR_REQUIRED' => new self($rpc, 'Message author required.', $code, $caller, $previous),
            'MESSAGE_DELETE_FORBIDDEN' => new self($rpc, 'You can\'t delete one of the messages you tried to delete, most likely because it is a service message.', $code, $caller, $previous),
            'POLL_VOTE_REQUIRED' => new self($rpc, 'Cast a vote in the poll before calling this method.', $code, $caller, $previous),
            'PRIVACY_PREMIUM_REQUIRED' => new \danog\MadelineProto\RPCError\PrivacyPremiumRequiredError($code, $caller, $previous),
            'PUBLIC_CHANNEL_MISSING' => new self($rpc, 'You can only export group call invite links for public chats or channels.', $code, $caller, $previous),
            'RIGHT_FORBIDDEN' => new self($rpc, 'Your admin rights do not allow you to do this.', $code, $caller, $previous),
            'SENSITIVE_CHANGE_FORBIDDEN' => new self($rpc, 'You can\'t change your sensitive content settings.', $code, $caller, $previous),
            'USER_DELETED' => new self($rpc, 'You can\'t send this secret message because the other participant deleted their account.', $code, $caller, $previous),
            'USER_PRIVACY_RESTRICTED' => new self($rpc, 'The user\'s privacy settings do not allow you to do this.', $code, $caller, $previous),
            'USER_RESTRICTED' => new self($rpc, 'You\'re spamreported, you can\'t create channels or chats.', $code, $caller, $previous),
            'CALL_PROTOCOL_COMPAT_LAYER_INVALID' => new self($rpc, 'The other side of the call does not support any of the VoIP protocols supported by the local client, as specified by the `protocol.layer` and `protocol.library_versions` fields.', $code, $caller, $previous),
            'FILEREF_UPGRADE_NEEDED' => new self($rpc, 'The client has to be updated in order to support [file references](https://core.telegram.org/api/file_reference).', $code, $caller, $previous),
            'FRESH_CHANGE_PHONE_FORBIDDEN' => new self($rpc, 'You can\'t change phone number right after logging in, please wait at least 24 hours.', $code, $caller, $previous),
            'FRESH_RESET_AUTHORISATION_FORBIDDEN' => new self($rpc, 'You can\'t logout other sessions if less than 24 hours have passed since you logged on the current session.', $code, $caller, $previous),
            'PAYMENT_UNSUPPORTED' => new \danog\MadelineProto\RPCError\PaymentUnsupportedError($code, $caller, $previous),
            'PHONE_PASSWORD_FLOOD' => new self($rpc, 'You have tried logging in too many times.', $code, $caller, $previous),
            'SEND_CODE_UNAVAILABLE' => new self($rpc, 'Returned when all available options for this type of number were already used (e.g. flash-call, then SMS, then this error might be returned to trigger a second resend).', $code, $caller, $previous),
            'STICKERSET_OWNER_ANONYMOUS' => new self($rpc, 'Provided stickerset can\'t be installed as group stickerset to prevent admin deanonymization.', $code, $caller, $previous),
            'UPDATE_APP_TO_LOGIN' => new self($rpc, 'Please update to the latest version of MadelineProto to login.', $code, $caller, $previous),
            'USERPIC_PRIVACY_REQUIRED' => new self($rpc, 'You need to disable privacy settings for your profile picture in order to make your geolocation public.', $code, $caller, $previous),
            default => new self($rpc, self::report($rpc, $code, $caller), $code, $caller, $previous)
        };

        // End match
    }

    protected function __construct(
        /**
         * @var string RPC error.
         */
        public readonly string $rpc,
        /**
         * @var string Human-readable description of RPC error.
         */
        public readonly string $description,
        int $code,
        private readonly string $caller,
        ?\Exception $previous = null
    ) {
        parent::__construct($rpc, $code, $previous);
        $this->prettifyTL($caller);
        foreach ($this->getTrace() as $level) {
            if (isset($level['function']) && $level['function'] === 'methodCall') {
                $this->line = $level['line'];
                $this->file = $level['file'];
            }
        }
    }
}
