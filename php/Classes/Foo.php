<?php
/**This is the Author Class for Medium
 *
 * I am using this for my Object Oriented Phase 1 learning to help me understand object oriented thinking.
 *
 * Author: Nehomah Mora <nehomahm@gmail.com>
 * */
class Author {
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
		return($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param int $newAuthorId new value of author id
	 * @throws UnexpectedValueException if $newAuthorId is not an integer
	 */
	public function setAuthorId( $newAuthorId) : {
	//verify the author id is valid
		$newAuthorId = filter_var($newAuthorId, FILTER_VALIDATE_INT);
	if ($newAuthorId === false){
		throw(new UnexpectedValueException("profile id is not a valid integer"));
		}
	//convert and store the author id
		$this->authorId = intval($newAuthorId);
	}
}
?>