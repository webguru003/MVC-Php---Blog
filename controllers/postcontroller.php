<?php
/**
 * @class PostController
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
class PostController extends Controller
{
	/**
	* Consturctor of PostController is initiated.
	* 
	* @param $model PostModel and $action method of this class
	* @return Constructor doesn't get return values; they serve entirely to instantiate the class.
	*/
	public function __construct($model, $action)
	{
		/**
		* Consturctor of Controller is initiated.
		* 
		* @param $model PostModel and $action method of this class
		* @return Constructor doesn't get return values; they serve entirely to instantiate the class.
		*/
		parent::__construct($model, $action);
		
		/**
		* This method is used to set Model of current class $this;
		*/ 
		$this->_setModel($model);
	}
	
	/**
	* This method is used to load Post form and Post Listing .
	* 
	* @param no parameter
	* @return index view
	*/
	public function index()
	{
		/**
		* Exception handling; try block.
		*/ 
		try {	/**
				* This method calling getPostById(int) is used to call PostModel call method and find the Post by Id.
				* 
				* @param no parameter
				* @return array $posts
				*/
				$posts = $this->_model->getPosts();
		
				/**
				* @!empty (is not empty) is used to check the array $post; depending If the array $post is not empty; if block, otherwise else belock will be encountered.
				*/ 
				if(!empty($posts))
				{
					$this->_view->set('title', 'Comment System');
					$this->_view->set('posts', $posts);
				}
				else 
				{
					$this->_view->set('title', 'No Post exists');
					$this->_view->set('noPost', true);
				}
				
				$this->_view->set('posts', $posts);
				
				/**
				* @return index view; $_view is a protected variable defined in Controller class.
				*/ 
				return $this->_view->output();
			
		} 
		catch (Exception $e) {
			/**
			* Exception handling; catch block.
			*/ 
			echo '<h1>Application error:</h1>' . $e->getMessage();
		}
		
		/**
		* @return index view; $_view is a protected variable defined in Controller class.
		*/ 
		return $this->_view->output();
	}
	
	/**
	* This method is used to view detail and related comments.
	* 
	* @param integer $postId the Post Id
    * @return details view
	*/
	public function details($postId)
	{
		/**
		* Exception handling; try block.
		*/ 
		try {	
				/**
				* This method calling getPostById(int) is used to call PostModel call method and find the Post by Id.
				* 
				* @param integer $postId the Post Id
				* @return array $posts
				*/
				$posts = $this->_model->getPostById((int)$postId);

				/**
				* Creating object of CommentModel Class.
				* 
				* @obj Object Created
				* @return object $comment_obj
				*/
				$comment_obj = new CommentModel();
				
				/**
				* This method calling getCommentByPostId(int) is used to fetch comments by PostID
				* 
				* @param integer $postId the Post Id
				* @return array $comments; post related
				*/
				$comments = $comment_obj->getCommentByPostId((int)$postId);

				/**
				* Checking array $post; true/false depending on whether the array is not empty,otherwise the else block will be encountered.
				*/ 
				if(!empty($posts))
				{
					$this->_view->set('name', $posts['name']);			
					$this->_view->set('message', $posts['message']);
					$this->_view->set('date', $posts['date']);
					$this->_view->set('post_id', $posts['id']);
					$this->_view->set('comment_list',$comments);
				}
				else 
				{
					$this->_view->set('title', 'Invalid article ID');
					$this->_view->set('noPost', true);
				}
				
				/**
				* Return details view;  $_view is a protected variable defined in Controller class.
				*/ 
				return $this->_view->output();
			 
		} catch (Exception $e) {
				$this->_view->set('title', $e->getMessage());
				$this->_view->set('noPost', true);
		}
	}
	
	
	/**
	* This method is used to save the data sent via AJAX.
	* 
	* @param No parameter
	* @return JSON
	*/
    public function addPost()
    {
		
		$name = isset($_POST['name']) ? trim($_POST['name']) : NULL;
		$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		$message = isset($_POST['message']) ? trim($_POST['message']) : "";
		
		/**
		* Array $errors is created; to keep error messages in catch block; cause code failure in try class. 
		*/ 	
		$errors = array();
		
		/**
		* Create Array $arr; passing by reference parameter to validate method. 
		*/ 
		$arr = array();
		
		/**
		* This calling method is used to validate form data; sent via AJAX and assigned to local variables.
		* 
		* $param $arr array
		* @return true/false
		*/ 
		$validates = $this->validate($arr);
		
        if (!$validates)
		{
			echo '{"status":0,"errors":'.json_encode($arr).'}';
			exit;
		}
			
		try {
		
			/**
			* Setting up PostModel class variables.
			* 
			* @param string $name, string $email and array $message
			* @return true on success or the error
			*/			
			$this->_model->setName($name);
			$this->_model->setEmail($email);
			$this->_model->setMessage($message);
			$post_id = (int)$this->_model->savePost();
			
			/**
			* This method is used to markup html.
			*/ 
			$html_here = $this->postMarkup($post_id);
			
			/**
			* Return JSON on success
			*/ 
			echo json_encode(array('status'=>1,'html'=>$html_here));
			exit;
					
		} catch (Exception $e) {
			/**
			* Return exception in JSON format on try block failure
			*/ 
			$errors['message'] = 'There was an error saving the data!';
			echo '{"status":0,"errors":'.json_encode($errors).'}';
			exit;
		}
    }
	
	/**
	* This method is used to add/save comment; the data sent via AJAX.
	* 
	* @param no parameter
	* @return JSON
	*/
	public function addComment()
    {

		/**
		* This method is used to add comment the data sent via AJAX.
		* 
		* @var $_POST variables $name string, $email string, $message string, $post_id integer
		* @return JSON
		*/
		$name = isset($_POST['name']) ? trim($_POST['name']) : NULL;
		$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		$message = isset($_POST['message']) ? trim($_POST['message']) : "";
		$post_id = $_POST['post_id'];
		
		/**
		* Array $errors is created; to keep error messages in catch block; cause code failure in try class. 
		*/
		$errors = array();
		
		/**
		* Create Array $arr; passing by reference parameter to validate method. 
		*/
		$arr = array();
		$validates = $this->validate($arr);
		
        if (!$validates)
		{
			echo '{"status":0,"errors":'.json_encode($arr).'}';
			exit;
		}
			
		try {
			/**
			* Creating CommentModel class object $comment_obj; to access CommentModel class variables and methods.
			*/ 		
			$comment_obj = new CommentModel();
			
			/**
			* Setting up PostModel class variables.
			* 
			* @param string $name, string $email, array $message and integer $post_id
			* @return true/false
			*/	
			
			$comment_obj->setName($name);
			$comment_obj->setEmail($email);
			$comment_obj->setMessage($message);
			$comment_obj->setPostId($post_id);
			$comment_id = $comment_obj->saveComment();
			
			
			$html_here = $this->commentMarkup($comment_id);
			
			echo json_encode(array('status'=>1,'html'=>$html_here));
			exit;
			
		} catch (Exception $e) {
			$errors['message'] = 'There was an error saving the data!';
			echo '{"status":0,"errors":'.json_encode($errors).'}';
			exit;
		}
    }

	public function postMarkup($post_id)
	{
		$post_arr = $this->_model->getPostById((int)$post_id);

		$html = '<div class="comment">
		<div><a href="./post/details/'.$post_id.'">'.$post_arr['message'].'</a></div>
		<div class="name">Published on '.$post_arr['date'].' by '.$post_arr['name'].'</div>';
			
		return  $html;
	}
	
	public function commentMarkup($commentId)
	{
		$comment_obj = new CommentModel();
		$comment_arr = $comment_obj->getCommentById((int)$commentId);

		$html = '<div class="comment">
		<div>'.$comment_arr['message'].'</div>
		<div class="name">Published on '.$comment_arr['date'].' by '.$comment_arr['name'].'</div>';

		return  $html;
	}
	
	/**
	* This method is used to validate the data sent via AJAX.
	* 
	* @param Array  &$arr passing by reference and form data $data($_POST)
	* @return  true/false depending on whether the data is valid, and populates
	* 		   the $arr array passed as a paremter (notice the ampersand above) with
	*          either the valid input data, or the error messages
	*/
	
	
	public static function validate(&$arr)
	{	
		/**
		* This arrray $errors is used to keep errors.
		*/
		$errors = array();
		
		/**
		* Using the filter_input function introduced in PHP 5.2.0.
		*/ 
		if(!($data['email'] = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)))
		{
			$errors['email'] = 'Please enter a valid Email.';
		}
		
		if(!($data['name'] = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING)))
		{
			$errors['name'] = 'Please enter your name.';
		}
		
		if(!($data['message'] = filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING)))
		{
			$errors['message'] = 'Please enter a message.';
		}
		
		if(!empty($errors)){
			/**
			* If there are errors, copy the $errors array to $arr:
			*/
			$arr = $errors;
			return false;
		}
		
		/**
		* If the data is valid, copy the $data array to $arr:
		*/
		
		foreach($data as $k=>$v){
			$arr[$k] = $v;
		}
		
		/**
		* Ensure that the email is lower case:
		*/ 
		
		$arr['email'] = strtolower(trim($arr['email']));
		
		/**
		* @return true if the data is successfully valideted:
		*/ 
		return true;
	}
}