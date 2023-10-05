<?php declare(strict_types=1);
/**
 * This file is automatic generated by build_docs.php file
 * and is used only for autocomplete in multiple IDE
 * don't modify manually.
 */

namespace danog\MadelineProto\Namespace;

interface Chatlists
{
    /**
     * Export a [folder »](https://core.telegram.org/api/folders), creating a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The folder to export @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param string $title An optional name for the link
     * @param list<array|int|string>|array<never, never> $peers Array of The list of channels, group and supergroups to share with the link. Basic groups will automatically be [converted to supergroups](https://core.telegram.org/api/channel#migration) when invoking the method. @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'chatlists.exportedChatlistInvite', filter: array{_: 'dialogFilter', contacts: bool, non_contacts: bool, groups: bool, broadcasts: bool, bots: bool, exclude_muted: bool, exclude_read: bool, exclude_archived: bool, id: int, title: string, emoticon: string, pinned_peers: list<array|int|string>, include_peers: list<array|int|string>, exclude_peers: list<array|int|string>}|array{_: 'dialogFilterDefault'}|array{_: 'dialogFilterChatlist', has_my_invites: bool, id: int, title: string, emoticon: string, pinned_peers: list<array|int|string>, include_peers: list<array|int|string>}, invite: array{_: 'exportedChatlistInvite', title: string, url: string, peers: list<array|int|string>}} @see https://docs.madelineproto.xyz/API_docs/types/chatlists.ExportedChatlistInvite.html
     */
    public function exportChatlistInvite(array $chatlist, string|null $title = '', array $peers = [], ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Delete a previously created [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The related folder @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param string $slug `slug` obtained from the [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     */
    public function deleteExportedInvite(array $chatlist, string|null $slug = '', ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): bool;

    /**
     * Edit a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist Folder ID @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param string $slug `slug` obtained from the [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     * @param string $title If set, sets a new name for the link
     * @param list<array|int|string>|array<never, never> $peers Array of If set, changes the list of peers shared with the link @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'exportedChatlistInvite', title: string, url: string, peers: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/ExportedChatlistInvite.html
     */
    public function editExportedInvite(array $chatlist, string|null $slug = '', string|null $title = '', array $peers = [], ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * List all [chat folder deep links »](https://core.telegram.org/api/links#chat-folder-links) associated to a folder.
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The folder @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'chatlists.exportedInvites', invites: list<array{_: 'exportedChatlistInvite', title: string, url: string, peers: list<array|int|string>}>, chats: list<array|int|string>, users: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/chatlists.ExportedInvites.html
     */
    public function getExportedInvites(array $chatlist, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Obtain information about a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param string $slug `slug` obtained from the [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links)
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'chatlists.chatlistInviteAlready', filter_id: int, missing_peers: list<array|int|string>, already_peers: list<array|int|string>, chats: list<array|int|string>, users: list<array|int|string>}|array{_: 'chatlists.chatlistInvite', title: string, emoticon: string, peers: list<array|int|string>, chats: list<array|int|string>, users: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/chatlists.ChatlistInvite.html
     */
    public function checkChatlistInvite(string|null $slug = '', ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Import a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links), joining some or all the chats in the folder.
     *
     * @param string $slug `slug` obtained from a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     * @param list<array|int|string>|array<never, never> $peers Array of List of new chats to join, fetched using [chatlists.checkChatlistInvite](https://docs.madelineproto.xyz/API_docs/methods/chatlists.checkChatlistInvite.html) and filtered as specified in the [documentation »](https://core.telegram.org/api/folders#shared-folders). @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array @see https://docs.madelineproto.xyz/API_docs/types/Updates.html
     */
    public function joinChatlistInvite(string|null $slug = '', array $peers = [], ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Fetch new chats associated with an imported [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links). Must be invoked at most every `chatlist_update_period` seconds (as per the related [client configuration parameter »](https://core.telegram.org/api/config#chatlist-update-period)).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The folder @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'chatlists.chatlistUpdates', missing_peers: list<array|int|string>, chats: list<array|int|string>, users: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/chatlists.ChatlistUpdates.html
     */
    public function getChatlistUpdates(array $chatlist, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Join channels and supergroups recently added to a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The folder @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param list<array|int|string>|array<never, never> $peers Array of List of new chats to join, fetched using [chatlists.getChatlistUpdates](https://docs.madelineproto.xyz/API_docs/methods/chatlists.getChatlistUpdates.html) and filtered as specified in the [documentation »](https://core.telegram.org/api/folders#shared-folders). @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array @see https://docs.madelineproto.xyz/API_docs/types/Updates.html
     */
    public function joinChatlistUpdates(array $chatlist, array $peers = [], ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Dismiss new pending peers recently added to a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist The folder @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     */
    public function hideChatlistUpdates(array $chatlist, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): bool;

    /**
     * Returns identifiers of pinned or always included chats from a chat folder imported using a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links), which are suggested to be left when the chat folder is deleted.
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist Folder ID @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return list<array|int|string> Array of  @see https://docs.madelineproto.xyz/API_docs/types/Peer.html
     */
    public function getLeaveChatlistSuggestions(array $chatlist, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array|null;

    /**
     * Delete a folder imported using a [chat folder deep link »](https://core.telegram.org/api/links#chat-folder-links).
     *
     * @param array{_: 'inputChatlistDialogFilter', filter_id?: int} $chatlist Folder ID @see https://docs.madelineproto.xyz/API_docs/types/InputChatlist.html
     * @param list<array|int|string>|array<never, never> $peers Array of Also leave the specified channels and groups @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array @see https://docs.madelineproto.xyz/API_docs/types/Updates.html
     */
    public function leaveChatlist(array $chatlist, array $peers = [], ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;
}
