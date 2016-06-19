<?php
namespace wcf\system\util;

/**
 * Represents a steamUtil.
 *
 * @author           Joshua Ruesweg
 * @copyright        2015-2016 wcflabs.de
 * @license          WCFLabs.de-Lizenz <https://wcflabs.de/license/license.txt>
 * @package          de.wcflabs.goodlive.steamGame.jcoins
 */
class SteamUtil {
	/**
	 * converts a steamID64 into a real steamID
	 * @param $oldSteamID
	 * @return string
	 */
	public static function steamID64ToSteamID($oldSteamID) {
		$z = bcdiv(bcsub($oldSteamID, '76561197960265728'), '2');
		$y = bcmod($oldSteamID, '2');
		return $y . ':' . floor($z);
	}
}
