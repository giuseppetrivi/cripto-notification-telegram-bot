<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultCachedPhoto.
 *
 * Represents a link to a photo stored on the Telegram servers. By default, this photo will be sent by the user with
 * an optional caption. Alternatively, you can use input_message_content to send a message with the specified content
 * instead of the photo.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *   'photo_file_id'          => '',  //  string                - Required. A valid file identifier of the photo
 *   'title'                  => '',  //  string                - (Optional). Title for the result
 *   'description'            => '',  //  string                - (Optional). Short description of the result
 *   'caption'                => '',  //  string                - (Optional). Caption of the photo to be sent, 0-200 characters
 *   'parse_mode'             => '',  //  string                - (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 *   'caption_entities'       => '',  //  array                 - (Optional). List of special entities that appear in the caption, which can be specified instead of parse_mode
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the photo
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultcachedphoto
 *
 * @method $this setId(string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setPhotoFileId(string)         A valid file identifier of the photo
 * @method $this setTitle(string)               (Optional). Title for the result
 * @method $this setDescription(string)         (Optional). Short description of the result
 * @method $this setCaption(string)             (Optional). Caption of the photo to be sent, 0-200 characters
 * @method $this setParseMode(string)           (Optional). Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in the media caption.
 * @method $this setReplyMarkup(object)         (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object) (Optional). Content of the message to be sent instead of the photo
 */
class InlineQueryResultCachedPhoto extends InlineBaseObject
{
    protected $type = 'photo';
}
