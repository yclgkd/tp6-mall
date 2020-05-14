<?php
/**
 * Author: Chunlai<chunlai0928@foxmail.com>
 * Date: 2020/4/29
 * Time: 2:23
 */
namespace app\lib\phpqrcode;
class Qrconst {
    const QR_MODE_NUL = -1;
    const QR_MODE_NUM = 0;
    const QR_MODE_AN = 1;
    const QR_MODE_8 = 2;
    const QR_MODE_KANJI = 3;
    const QR_MODE_STRUCTURE = 4;

        // Levels of error correction.

    const QR_ECLEVEL_L = 0;
    const QR_ECLEVEL_M = 1;
    const QR_ECLEVEL_Q = 2;
    const QR_ECLEVEL_H = 3;

        // Supported output formats

    const QR_FORMAT_TEXT = 0;
    const QR_FORMAT_PNG = 1;
    const QR_CACHEABLE = false;       // use cache - more disk reads but less CPU power, masks and format templates are stored there
    const QR_CACHE_DIR = false;       // used when QR_CACHEABLE === true
    const QR_LOG_DIR = false;         // default error logs dir

    const QR_FIND_BEST_MASK = true;                                                          // if true, estimates best mask (spec. default, but extremally slow; set to false to significant performance boost but (propably) worst quality code
    const QR_FIND_FROM_RANDOM = 2;                                                       // if false, checks all masks available, otherwise value tells count of masks need to be checked, mask id are got randomly
    const QR_DEFAULT_MASK = 2;                                                               // when QR_FIND_BEST_MASK === false

    const QR_PNG_MAXIMUM_SIZE = 1024;


    const QRSPEC_VERSION_MAX = 40;
    const QRSPEC_WIDTH_MAX = 177;

    const QRCAP_WIDTH = 0;
    const QRCAP_WORDS = 1;
    const QRCAP_REMINDER = 2;
    const QRCAP_EC = 3;
    const QR_IMAGE = true;
    const STRUCTURE_HEADER_BITS = 20;
    const MAX_STRUCTURED_SYMBOLS = 16;
}