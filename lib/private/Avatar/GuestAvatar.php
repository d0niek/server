<?php
declare(strict_types=1);

/**
 * @copyright Copyright (c) 2018, Michael Weimann <mail@michael-weimann.eu>
 *
 * @author Michael Weimann <mail@michael-weimann.eu>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 */

namespace OC\Avatar;

use OCP\Files\SimpleFS\InMemoryFile;
use OCP\ILogger;

/**
 * This class represents a guest user's avatar.
 */
class GuestAvatar extends Avatar {
	/**
	 * Holds the guest user display name.
	 *
	 * @var string
	 */
	private $userDisplayName;

	/**
	 * GuestAvatar constructor.
	 *
	 * @param string $userDisplayName The guest user display name
	 * @param ILogger $logger The logger
	 */
	public function __construct(string $userDisplayName, ILogger $logger) {
		parent::__construct($logger);
		$this->userDisplayName = $userDisplayName;
	}

	/**
	 * Tests if the user has an avatar.
	 *
	 * @return true Guests always have an avatar.
	 */
	public function exists() {
		return true;
	}

	/**
	 * Returns the guest user display name.
	 *
	 * @return string
	 */
	public function getDisplayName(): string {
		return $this->userDisplayName;
	}

	/**
	 * Setting avatars isn't implemented for guests.
	 *
	 * @param \OCP\IImage|resource|string $data
	 * @return void
	 */
	public function set($data) {
		// unimplemented for guest user avatars
	}

	/**
	 * Removing avatars isn't implemented for guests.
	 */
	public function remove() {
		// unimplemented for guest user avatars
	}

	/**
	 * Generates an avatar for the guest.
	 *
	 * @param int $size The desired image size.
	 * @return InMemoryFile
	 */
	public function getFile($size) {
		$avatar = $this->getAvatarVector($size);
		return new InMemoryFile('avatar.svg', $avatar);
	}

	/**
	 * Updates the display name if changed.
	 *
	 * @param string $feature The changed feature
	 * @param mixed $oldValue The previous value
	 * @param mixed $newValue The new value
	 * @return void
	 */
	public function userChanged($feature, $oldValue, $newValue) {
		if ($feature === 'displayName') {
			$this->userDisplayName = $newValue;
		}
	}

	/**
	 * Guests don't have custom avatars.
	 *
	 * @return bool
	 */
	public function isCustomAvatar(): bool {
		return false;
	}
}
