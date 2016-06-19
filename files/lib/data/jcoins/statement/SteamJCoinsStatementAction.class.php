<?php
namespace wcf\data\jcoins\statement;
use wcf\system\database\MySQLDatabase;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\SystemException;
use wcf\system\exception\UserInputException;
use wcf\system\user\jcoins\UserJCoinsStatementHandler;
use wcf\system\WCF;
use wcf\system\util\SteamUtil;

/**
 * Represents a steam JCoins Statement entry.
 *
 * @author           Joshua Ruesweg
 * @copyright        2015-2016 wcflabs.de
 * @license          WCFLabs.de-Lizenz <https://wcflabs.de/license/license.txt>
 * @package          de.wcflabs.goodlive.steamGame.jcoins
 */
class SteamJCoinsStatementAction extends JCoinsStatementAction {
	
	/**
	 * @inerhitDoc
	 */
	protected $className = '\wcf\data\jcoins\statement\JCoinsStatementEditor';
	
	/**
	 * @var \wcf\system\database\MySQLDatabase
	 */
	private static $connection = null;
	
	/**
	 * Returns the transfer to steam overlay 
	 * @return array
	 */
	public function getTransferToSteamOverlay() {
		return array(
			'template' => WCF::getTPL()->fetch('transferToSteamOverlay')
		);
	}
	
	/**
	 * validates the transfer to steam overlay 
	 */
	public function validateGetTransferToSteamOverlay() {
		if (!WCF::getUser()->userID) {
			throw new PermissionDeniedException(); 
		}
		
		if (!WCF::getUser()->steamID64) {
			throw new PermissionDeniedException(); 
		}
	}
	
	/**
	 * Transfer amount to steam.
	 */
	public function transferToSteam() {
		self::getSteamDatabase()->prepareStatement("UPDATE store_players SET credits = credits + ? WHERE authid = ?")->execute(array(
			$this->parameters['amount'] * JCOINS_STEAM_EXCHANGE,
			SteamUtil::steamID64ToSteamID(WCF::getUser()->steamID64)
		));

		UserJCoinsStatementHandler::getInstance()->create('de.wcflabs.jcoins.statement.steam.transfer', null, array(
			'amount' => ($this->parameters['amount'] * -1),
			'userID' => WCF::getUser()->userID
		));
        return array(
            'success' => true
        );
	}
	
	/**
	 * validates the transfer to steam
	 */
	public function validateTransferToSteam() {
		$this->readInteger('amount');
		
		if (!WCF::getUser()->userID) {
			throw new PermissionDeniedException();
		}
		
		if (!WCF::getUser()->steamID64) {
			throw new PermissionDeniedException();
		}
		
		if (WCF::getUser()->jCoinsAmount < $this->parameters['amount']) {
			throw new UserInputException('amount');
		}
	}
	
	/**
	 * Returns the steam database 
	 * 
	 * @return MySQLDatabase
	 */
	public static function getSteamDatabase() {
		if (self::$connection === null) {
			try {
				self::$connection = new MySQLDatabase(JCOINS_STEAM_HOST, JCOINS_STEAM_USER, JCOINS_STEAM_PASSWORD, JCOINS_STEAM_DATABASE, JCOINS_STEAM_PORT);
			} catch (SystemException $e) {
				throw new SystemException('cannot connect to steam database');
			}
		}
		return self::$connection; 
	}
}
