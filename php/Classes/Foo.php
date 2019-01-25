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
	 * email for the Author; this is a foreign key
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
}
?>