<?php
namespace Edu\Cnm\DataDesign;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**This is the Author Class for Medium
 *
 * I am using this for my Object Oriented Phase 1 learning to help me understand object oriented thinking.
 *
 * Author: Nehomah Mora <nehomahm@gmail.com>
 * */
class Author implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this Author; this is the primary key
	 */
	private $authorId;
	/**
	 * email for the Author; this is an index
	 */
	private $authorEmail;
	/**
	 * authors activation token
	 */
	private $authorActivationToken;
	/**
	 * authors Avatar
	 */
	private $authorAvatarUrl;
	/**
	 * authors hash
	 */
	private $authorHash;
	/**
	 * authors username
	 */
	private $authorUsername;

	/**
	 *accessor method for author id
	 *
	 * #return int value of author id
	 */
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param int $newAuthorId new value of author id
	 * @throws UnexpectedValueException if $newAuthorId is not an integer
	 */
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author email
	 *
	 * return author email
	 */
	public function getAuthorEmail(): string {
		return ($this->authorEmail);
	}

	/**mutator method for author email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws  \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 * */
	public function setAuthorEmail(string $newAuthorEmail): void {
		//verify the email is secure
		$newAuthorEmail = trim(@$newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty(@$newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen(@$newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * Accessor method for author activation token
	 *
	 * return author activation token
	 */
	public function getAuthorActivationToken(): string {
		return ($this->authorActivationToken);
	}

	/**
	 * Mutator method for author activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->newAuthorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw (new\RangeException("author activation is not valid"));
		}
		//make sure activation toke is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("author activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}
	/**Accessor method for author avatar url
	 *
	 * return author avatar url
	 */
	public function getAuthorAvatarUrl(): string {
		return $this->authorAvatarUrl;
	}
	/**Mutator method for author avatar URL
	 *
	 * @param string $newAuthorAvatarUrl
	 * @throws \InvalidArgumentException if the url is not secure
	 * @throws \RangeException if the url is > 128 characters
	 * @throws \TypeError if the url is not a string
	 * */
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		if($newAuthorAvatarUrl === null) {
			$this->authorAvatarUrl = null;
			return;
		}
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("url is empty or insecure"));
		}
		if(strlen($newAuthorAvatarUrl) !== 128) {
			throw(new \RangeException("url must be less than 128 characters"));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}
	/**Accessor methos for Author Hash
	 *
	 * returns author hash
	 * */
	/**
	 * @return mixed
	 */
	public function getAuthorHash() : string{
		return $this->authorHash;
	}
	/**Mutator method for Author Hash
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if the hash is not a string
	 * */
	public function setAuthorHash(string $newAuthorHash): void {
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = strtolower($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author hash is empty or insecure"));
		}
		if(!ctype_xdigit($newAuthorHash)) {
			throw(new \InvalidArgumentException("author has is empty or insecure"));
		}
		if(strlen($newAuthorHash) !== 128) {
				throw(new \RangeException("author hash must be 128 characters"));
		}
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * Accessor method for Author Username
	 *
	 * @return author username
	 */
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}
	/**
	 * Mutator method for Author Username
	 *
	 * @param string $newAuthorUsername new username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or insecure
	 * @throws \RangeException if @newAuthorUsername is > 32 characters
	 * @throws \TypeErrorif $newAuthorUsername is not a string
	 **/
	public function setAuthorUsername(string $newAuthorUsername) : void {
		$newAuthorUsername = trim($newAuthorUsername);
		$newAuthorUsername = filter_var($newAuthorUsername, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("username is empty or insecure"));
		}
		if(strlen($newAuthorUsername) > 32) {
			throw(new \RangeException("username is too long"));
			$this->authorUsername = $newAuthorUsername;
		}
	}
	/**formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 * */
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorHash"]);
		unset($fields["authorUsername"]);
		return ($fields);
	}
}