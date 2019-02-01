<?php
namespace Nmora9\Author;
require_once("../../vendor/autoload.php");
require_once("autoload.php");

use Ramsey\Uuid\Uuid;
/**This is the Author Class for Medium
 *
 * I am using this for my Object Oriented Phase 1 learning to help me understand object oriented thinking.
 *
 * Author: Nehomah Mora <nehomahm@gmail.com>
 * */
class Author implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/**
	 * token handed out to verify that a profile is valid and not malicious
	 * @var string $authorActivationToken
	 */
	private $authorActivationToken;
	/**
	 * authors Avatar url
	 * @var string $authorAvatarUrl
	 */
	private $authorAvatarUrl;
	/**
	 * email for the Author; this is a unique index
	 * @var string $authorEmail
	 */
	private $authorEmail;
	/**
	 * Hash for authors password
	 * @var $authorHash
	 */
	private $authorHash;
	/**
	 * Authors username; this is a unique index
	 * @var string $authorUsername
	 */
	private $authorUsername;

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId Id of this Author or null is a new Author
	 * @param string $newAuthorActivationToken activation token to safe guard against malicious accounts
	 * @param string $newAuthorAvatarUrl string containing avatar url
	 * @param string $newAuthorEmail string containing email
	 * @param string $newAuthorHash string containing password hash
	 * @param string $newAuthorUsername string containing newUsername
	 * @throws \InvalidArgumentException if data types are not InvalidArgumentException
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
public function __construct($newAuthorId, string $newAuthorActivationToken, string $newAuthorAvatarUrl, string $newAuthorEmail,
string $newAuthorHash, string $newAuthorUsername) {
	try {
		$this->setAuthorId($newAuthorId);
		$this->setAuthorActivationToken($newAuthorActivationToken);
		$this->setAuthorAvatarUrl($newAuthorActivationToken);
		$this->setAuthorEmail($newAuthorEmail);
		$this->setAuthorHash($newAuthorHash);
		$this->setAuthorUsername($newAuthorUsername);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
}

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
		/**if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw (new\RangeException("author activation is not valid"));
		}
		make sure activation toke is only 32 characters
		**/
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
	 * @throws \RangeException if the url is > 255 characters
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
		if(strlen($newAuthorAvatarUrl) !== 255) {
			throw(new \RangeException("url must be less than 255 characters"));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
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
	/**Accessor method for Author Hash
	 *
	 * returns author hash
	 *
	 * */
	public function getAuthorHash() : string{
		return $this->authorHash;
	}
	/**Mutator method for Author Hash
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 97 characters
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
		if(strlen($newAuthorHash) !== 97) {
				throw(new \RangeException("author hash must be 97 characters"));
		}
		$this->authorHash = $newAuthorHash;
	}
	/**
	 * Accessor method for Author Username
	 *
	 * @return author username
	 **/
	public function getAuthorUsername(): string {
		return ($this->authorUsername);
	}
	/**
	 * Mutator method for Author Username
	 *
	 * @param string $newAuthorUsername new username
	 * @throws \InvalidArgumentException if $newAuthorUsername is not a string or insecure
	 * @throws \RangeException if @newAuthorUsername is > 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
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

	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) 
						VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authroUsername)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(),
			"authorActivationToken" => $this->authorActivationToken->getBytes(), "authorEmail" => $this->authorEmail->getBytes(),
			"authroHash" => $this->authorHash->getBytes(), "authorUsername" => $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE author SET authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl,
 					authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername 
 					WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken->getBytes(),
			"authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorEmail" => $this->authorEmail->getBytes(),
			"authorHash" => $this->authorHash->getBytes(), "authorUsername" => $this->authorUsername->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername 
						FROM author
						WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);
		// bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);
		// grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			}catch (\PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		if($row !== false) {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"],
					$row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				}
		return($author);
	}
	/**
	 * Get all authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of the authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variales are not the correct data type
	 */
	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername 
						FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row =$statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"],
					$row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$author->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOExeption($exception->getMessage(), 0, $exception));
			}
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

