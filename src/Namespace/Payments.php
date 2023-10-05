<?php declare(strict_types=1);
/**
 * This file is automatic generated by build_docs.php file
 * and is used only for autocomplete in multiple IDE
 * don't modify manually.
 */

namespace danog\MadelineProto\Namespace;

interface Payments
{
    /**
     * Get a payment form.
     *
     * @param array{_: 'inputInvoiceMessage', peer?: array|int|string, msg_id?: int}|array{_: 'inputInvoiceSlug', slug?: string} $invoice Invoice @see https://docs.madelineproto.xyz/API_docs/types/InputInvoice.html
     * @param mixed $theme_params Any JSON-encodable data
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.paymentForm', invoice: array{_: 'invoice', test: bool, name_requested: bool, phone_requested: bool, email_requested: bool, shipping_address_requested: bool, flexible: bool, phone_to_provider: bool, email_to_provider: bool, recurring: bool, currency: string, prices: list<array{_: 'labeledPrice', label: string, amount: int}>, max_tip_amount: int, suggested_tip_amounts: list<int>, terms_url: string}, can_save_credentials: bool, password_missing: bool, form_id: int, bot_id: int, title: string, description: string, photo?: array{_: 'webDocument', url: string, access_hash: int, size: int, mime_type: string, attributes: list<array{_: 'documentAttributeImageSize', w: int, h: int}|array{_: 'documentAttributeAnimated'}|array{_: 'documentAttributeSticker', mask: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}, mask_coords?: array{_: 'maskCoords', x: float, y: float, zoom: float, n: int}}|array{_: 'documentAttributeVideo', duration: float, round_message: bool, supports_streaming: bool, nosound: bool, w: int, h: int, preload_prefix_size: int}|array{_: 'documentAttributeAudio', voice: bool, duration: int, title: string, performer: string, waveform?: non-empty-list<int<0, 31>>}|array{_: 'documentAttributeFilename', file_name: string}|array{_: 'documentAttributeHasStickers'}|array{_: 'documentAttributeCustomEmoji', free: bool, text_color: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeSticker'}|array{_: 'documentAttributeVideo', duration: int, w: int, h: int}|array{_: 'documentAttributeAudio', duration: int}|array{_: 'documentAttributeSticker', alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeAudio', duration: int, title: string, performer: string}|array{_: 'documentAttributeVideo', round_message: bool, duration: int, w: int, h: int}>}|array{_: 'webDocumentNoProxy', url: string, size: int, mime_type: string, attributes: list<array{_: 'documentAttributeImageSize', w: int, h: int}|array{_: 'documentAttributeAnimated'}|array{_: 'documentAttributeSticker', mask: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}, mask_coords?: array{_: 'maskCoords', x: float, y: float, zoom: float, n: int}}|array{_: 'documentAttributeVideo', duration: float, round_message: bool, supports_streaming: bool, nosound: bool, w: int, h: int, preload_prefix_size: int}|array{_: 'documentAttributeAudio', voice: bool, duration: int, title: string, performer: string, waveform?: non-empty-list<int<0, 31>>}|array{_: 'documentAttributeFilename', file_name: string}|array{_: 'documentAttributeHasStickers'}|array{_: 'documentAttributeCustomEmoji', free: bool, text_color: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeSticker'}|array{_: 'documentAttributeVideo', duration: int, w: int, h: int}|array{_: 'documentAttributeAudio', duration: int}|array{_: 'documentAttributeSticker', alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeAudio', duration: int, title: string, performer: string}|array{_: 'documentAttributeVideo', round_message: bool, duration: int, w: int, h: int}>}, provider_id: int, url: string, native_provider: string, native_params?: mixed, additional_methods: list<array{_: 'paymentFormMethod', url: string, title: string}>, saved_info?: array{_: 'paymentRequestedInfo', name: string, phone: string, email: string, shipping_address?: array{_: 'postAddress', street_line1: string, street_line2: string, city: string, state: string, country_iso2: string, post_code: string}}, saved_credentials: list<array{_: 'paymentSavedCredentialsCard', id: string, title: string}>, users: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/payments.PaymentForm.html
     */
    public function getPaymentForm(array $invoice, mixed $theme_params = null, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Get payment receipt.
     *
     * @param array|int|string $peer The peer where the payment receipt was sent @see https://docs.madelineproto.xyz/API_docs/types/InputPeer.html
     * @param int $msg_id Message ID of receipt
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.paymentReceipt', invoice: array{_: 'invoice', test: bool, name_requested: bool, phone_requested: bool, email_requested: bool, shipping_address_requested: bool, flexible: bool, phone_to_provider: bool, email_to_provider: bool, recurring: bool, currency: string, prices: list<array{_: 'labeledPrice', label: string, amount: int}>, max_tip_amount: int, suggested_tip_amounts: list<int>, terms_url: string}, date: int, bot_id: int, provider_id: int, title: string, description: string, photo?: array{_: 'webDocument', url: string, access_hash: int, size: int, mime_type: string, attributes: list<array{_: 'documentAttributeImageSize', w: int, h: int}|array{_: 'documentAttributeAnimated'}|array{_: 'documentAttributeSticker', mask: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}, mask_coords?: array{_: 'maskCoords', x: float, y: float, zoom: float, n: int}}|array{_: 'documentAttributeVideo', duration: float, round_message: bool, supports_streaming: bool, nosound: bool, w: int, h: int, preload_prefix_size: int}|array{_: 'documentAttributeAudio', voice: bool, duration: int, title: string, performer: string, waveform?: non-empty-list<int<0, 31>>}|array{_: 'documentAttributeFilename', file_name: string}|array{_: 'documentAttributeHasStickers'}|array{_: 'documentAttributeCustomEmoji', free: bool, text_color: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeSticker'}|array{_: 'documentAttributeVideo', duration: int, w: int, h: int}|array{_: 'documentAttributeAudio', duration: int}|array{_: 'documentAttributeSticker', alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeAudio', duration: int, title: string, performer: string}|array{_: 'documentAttributeVideo', round_message: bool, duration: int, w: int, h: int}>}|array{_: 'webDocumentNoProxy', url: string, size: int, mime_type: string, attributes: list<array{_: 'documentAttributeImageSize', w: int, h: int}|array{_: 'documentAttributeAnimated'}|array{_: 'documentAttributeSticker', mask: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}, mask_coords?: array{_: 'maskCoords', x: float, y: float, zoom: float, n: int}}|array{_: 'documentAttributeVideo', duration: float, round_message: bool, supports_streaming: bool, nosound: bool, w: int, h: int, preload_prefix_size: int}|array{_: 'documentAttributeAudio', voice: bool, duration: int, title: string, performer: string, waveform?: non-empty-list<int<0, 31>>}|array{_: 'documentAttributeFilename', file_name: string}|array{_: 'documentAttributeHasStickers'}|array{_: 'documentAttributeCustomEmoji', free: bool, text_color: bool, alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeSticker'}|array{_: 'documentAttributeVideo', duration: int, w: int, h: int}|array{_: 'documentAttributeAudio', duration: int}|array{_: 'documentAttributeSticker', alt: string, stickerset: array{_: 'inputStickerSetEmpty'}|array{_: 'inputStickerSetID', id: int, access_hash: int}|array{_: 'inputStickerSetShortName', short_name: string}|array{_: 'inputStickerSetAnimatedEmoji'}|array{_: 'inputStickerSetDice', emoticon: string}|array{_: 'inputStickerSetAnimatedEmojiAnimations'}|array{_: 'inputStickerSetPremiumGifts'}|array{_: 'inputStickerSetEmojiGenericAnimations'}|array{_: 'inputStickerSetEmojiDefaultStatuses'}|array{_: 'inputStickerSetEmojiDefaultTopicIcons'}}|array{_: 'documentAttributeAudio', duration: int, title: string, performer: string}|array{_: 'documentAttributeVideo', round_message: bool, duration: int, w: int, h: int}>}, info?: array{_: 'paymentRequestedInfo', name: string, phone: string, email: string, shipping_address?: array{_: 'postAddress', street_line1: string, street_line2: string, city: string, state: string, country_iso2: string, post_code: string}}, shipping?: array{_: 'shippingOption', id: string, title: string, prices: list<array{_: 'labeledPrice', label: string, amount: int}>}, tip_amount: int, currency: string, total_amount: int, credentials_title: string, users: list<array|int|string>} @see https://docs.madelineproto.xyz/API_docs/types/payments.PaymentReceipt.html
     */
    public function getPaymentReceipt(array|int|string|null $peer = null, int|null $msg_id = 0, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Submit requested order information for validation.
     *
     * @param array{_: 'inputInvoiceMessage', peer?: array|int|string, msg_id?: int}|array{_: 'inputInvoiceSlug', slug?: string} $invoice Invoice @see https://docs.madelineproto.xyz/API_docs/types/InputInvoice.html
     * @param array{_: 'paymentRequestedInfo', name?: string, phone?: string, email?: string, shipping_address?: array{_: 'postAddress', street_line1?: string, street_line2?: string, city?: string, state?: string, country_iso2?: string, post_code?: string}} $info Requested order information @see https://docs.madelineproto.xyz/API_docs/types/PaymentRequestedInfo.html
     * @param bool $save Save order information to re-use it for future orders
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.validatedRequestedInfo', id: string, shipping_options: list<array{_: 'shippingOption', id: string, title: string, prices: list<array{_: 'labeledPrice', label: string, amount: int}>}>} @see https://docs.madelineproto.xyz/API_docs/types/payments.ValidatedRequestedInfo.html
     */
    public function validateRequestedInfo(array $invoice, array $info, bool|null $save = false, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Send compiled payment form.
     *
     * @param array{_: 'inputInvoiceMessage', peer?: array|int|string, msg_id?: int}|array{_: 'inputInvoiceSlug', slug?: string} $invoice Invoice @see https://docs.madelineproto.xyz/API_docs/types/InputInvoice.html
     * @param array{_: 'inputPaymentCredentialsSaved', id?: string, tmp_password?: string}|array{_: 'inputPaymentCredentials', data: mixed, save?: bool}|array{_: 'inputPaymentCredentialsApplePay', payment_data: mixed}|array{_: 'inputPaymentCredentialsGooglePay', payment_token: mixed} $credentials Payment credentials @see https://docs.madelineproto.xyz/API_docs/types/InputPaymentCredentials.html
     * @param int $form_id Form ID
     * @param string $requested_info_id ID of saved and validated [order info](https://docs.madelineproto.xyz/API_docs/constructors/payments.validatedRequestedInfo.html)
     * @param string $shipping_option_id Chosen shipping option ID
     * @param int $tip_amount Tip, in the smallest units of the currency (integer, not float/double). For example, for a price of `US$ 1.45` pass `amount = 145`. See the exp parameter in [currencies.json](https://core.telegram.org/bots/payments/currencies.json), it shows the number of digits past the decimal point for each currency (2 for the majority of currencies).
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.paymentResult', updates: array}|array{_: 'payments.paymentVerificationNeeded', url: string} @see https://docs.madelineproto.xyz/API_docs/types/payments.PaymentResult.html
     */
    public function sendPaymentForm(array $invoice, array $credentials, int|null $form_id = 0, string|null $requested_info_id = '', string|null $shipping_option_id = '', int|null $tip_amount = 0, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Get saved payment information.
     *
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.savedInfo', has_saved_credentials: bool, saved_info?: array{_: 'paymentRequestedInfo', name: string, phone: string, email: string, shipping_address?: array{_: 'postAddress', street_line1: string, street_line2: string, city: string, state: string, country_iso2: string, post_code: string}}} @see https://docs.madelineproto.xyz/API_docs/types/payments.SavedInfo.html
     */
    public function getSavedInfo(?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Clear saved payment information.
     *
     * @param bool $credentials Remove saved payment credentials
     * @param bool $info Clear the last order settings saved by the user
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     */
    public function clearSavedInfo(bool|null $credentials = false, bool|null $info = false, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): bool;

    /**
     * Get info about a credit card.
     *
     * @param string $number Credit card number
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.bankCardData', title: string, open_urls: list<array{_: 'bankCardOpenUrl', url: string, name: string}>} @see https://docs.madelineproto.xyz/API_docs/types/payments.BankCardData.html
     */
    public function getBankCardData(string|null $number = '', ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Generate an [invoice deep link](https://core.telegram.org/api/links#invoice-links).
     *
     * @param \danog\MadelineProto\EventHandler\Media|string|array $invoice_media Invoice @see https://docs.madelineproto.xyz/API_docs/types/InputMedia.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array{_: 'payments.exportedInvoice', url: string} @see https://docs.madelineproto.xyz/API_docs/types/payments.ExportedInvoice.html
     */
    public function exportInvoice(\danog\MadelineProto\EventHandler\Media|array|string|null $invoice_media = null, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Informs server about a purchase made through the App Store: for official applications only.
     *
     * @param array{_: 'inputStorePaymentPremiumSubscription', restore?: bool, upgrade?: bool}|array{_: 'inputStorePaymentGiftPremium', user_id?: array|int|string, currency?: string, amount?: int} $purpose Payment purpose @see https://docs.madelineproto.xyz/API_docs/types/InputStorePaymentPurpose.html
     * @param string $receipt Receipt
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array @see https://docs.madelineproto.xyz/API_docs/types/Updates.html
     */
    public function assignAppStoreTransaction(array $purpose, string|null $receipt = '', ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Informs server about a purchase made through the Play Store: for official applications only.
     *
     * @param mixed $receipt Any JSON-encodable data
     * @param array{_: 'inputStorePaymentPremiumSubscription', restore?: bool, upgrade?: bool}|array{_: 'inputStorePaymentGiftPremium', user_id?: array|int|string, currency?: string, amount?: int} $purpose Payment purpose @see https://docs.madelineproto.xyz/API_docs/types/InputStorePaymentPurpose.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     * @return array @see https://docs.madelineproto.xyz/API_docs/types/Updates.html
     */
    public function assignPlayMarketTransaction(mixed $receipt, array $purpose, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): array;

    /**
     * Checks whether Telegram Premium purchase is possible. Must be called before in-store Premium purchase, official apps only.
     *
     * @param array{_: 'inputStorePaymentPremiumSubscription', restore?: bool, upgrade?: bool}|array{_: 'inputStorePaymentGiftPremium', user_id?: array|int|string, currency?: string, amount?: int} $purpose Payment purpose @see https://docs.madelineproto.xyz/API_docs/types/InputStorePaymentPurpose.html
     * @param ?int $floodWaitLimit Can be used to specify a custom flood wait limit: if a FLOOD_WAIT_ rate limiting error is received with a waiting period bigger than this integer, an RPCErrorException will be thrown; otherwise, MadelineProto will simply wait for the specified amount of time. Defaults to the value specified in the settings: https://docs.madelineproto.xyz/PHP/danog/MadelineProto/Settings/RPC.html#setfloodtimeout-int-floodtimeout-self
     * @param bool $postpone If true, will postpone execution of this method until the first method call with $postpone = false to the same DC or a call to flush() is made, bundling all queued in a single container for higher efficiency. Will not return until the method is queued and a response is received, so this should be used in combination with \Amp\async.
     * @param ?string $queueId Usually, concurrent method calls are executed in arbitrary order: with this option, strict ordering for requests **to the same chat/datacenter** can be enforced by specifying the same queue ID for all methods that require strictly ordered execution.
     * @param ?\Amp\Cancellation $cancellation Cancellation
     */
    public function canPurchasePremium(array $purpose, ?int $floodWaitLimit = null, bool $postpone = false, ?string $queueId = null, ?\Amp\Cancellation $cancellation = null): bool;
}
