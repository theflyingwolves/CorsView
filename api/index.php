<?php
 $requestURI = explode('/', $_SERVER['REQUEST_URI']);
//$requestURI = explode('/', $_GET['url']);

//current api call starts with "localhost/corsview/api/..."
//54.164.2131/api/modules
$addr_offset = 3;
$command = array_values($requestURI);

//initialize the rest of $command to empty strings 
for ($i = sizeof($command); $i < $addr_offset + 15 ; $i++) {
    $command[$i]='';
}


switch($command[$addr_offset + 0]){
            case 'modules':
                        switch($command[$addr_offset+1]){
                                    case '':
                                                break;
                                    default:    //module code exists
                                                switch($command[$addr_offset + 2]){
                                                            case '':
                                                                        switch($_SERVER['REQUEST_METHOD']){
                                                                                    case 'GET':
                                                                                                require_once('modules.php');
                                                                                                getModuleInfo($command[$addr_offset + 1]);
                                                                                                break;
                                                                                    case 'POST':
                                                                                                break;
                                                                                    case 'PUT':
                                                                                                break;
                                                                                    case 'DELETE':
                                                                                                break;
                                                                                    default:
                                                                                                break;    
                                                                        }
                                                                        break;
                                                            case 'reviews':
                                                                        switch($command[$addr_offset+3]){
                                                                                    case '':
                                                                                            switch($_SERVER['REQUEST_METHOD']){
                                                                                                            case 'GET':
                                                                                                                        require_once('reviews.php');
                                                                                                                        getReviews($command[$addr_offset+1]);
                                                                                                                        break;
                                                                                                            case 'POST':
                                                                                                                        require_once('reviews.php');
                                                                                                                        $reviewDetails = json_decode(file_get_contents('php://input'), true);
                                                                                                                        addReview($reviewDetails);
                                                                                                                        break;
                                                                                                            default:   
                                                                                                                        break;    
                                                                                                }
                                                                                                break;
                                                                                    default:    //review id exists
                                                                                                switch($command[$addr_offset+4]){
                                                                                                      case '':
                                                                                                            switch($_SERVER['REQUEST_METHOD']){
                                                                                                                        case 'GET':
                                                                                                                                    require_once('reviews.php');
                                                                                                                                    getSpecificReview($command[$addr_offset+3]);
                                                                                                                                    break;
                                                                                                                        case 'PUT':
                                                                                                                                    require_once('reviews.php');
                                                                                                                                    $newReview = json_decode(file_get_contents('php://input'),true);
                                                                                                                                    modifyReview($command[$addr_offset+3],$newReview);
                                                                                                                                    break;
                                                                                                                        default:
                                                                                                                                    break;    
                                                                                                            }
                                                                                                            break; // case '': ../../api/modules/module_code/reviews/review_id/ ended
                                                                                                      case 'delete':
                                                                                                                        require_once('reviews.php');
                                                                                                                        deleteReview($command[$addr_offset+3],$command[$addr_offset+5],$command[$addr_offset+6]);
                                                                                                            break;
                                                                                                      case 'votes':
                                                                                                                        require_once('reviews.php');
                                                                                                                        $vote= json_decode(file_get_contents('php://input'),true);
                                                                                                                        reviewVote($vote);
                                                                                                            break;

                                                                                                      case 'comments':
                                                                                                            switch($command[$addr_offset+5]){
                                                                                                                  case '':
                                                                                                                        switch($_SERVER['REQUEST_METHOD']){

                                                                                                                              case 'POST':
                                                                                                                                          require_once('review_comments.php');
                                                                                                                                          $newReviewComment = json_decode(file_get_contents('php://input'),true);
                                                                                                                                          //print_r($newReviewComment);
                                                                                                                                          postReviewComment($newReviewComment);
                                                                                                                                          break;
                                                                                                                              case 'GET':
                                                                                                                                          require_once('review_comments.php');
                                                                                                                                          getComments($command[$addr_offset+3]);
                                                                                                                                          break;
                                                                                                                        }
                                                                                                                        break;
                                                                                                                  default: // comment id exists
                                                                                                                        switch($command[$addr_offset+6]){
                                                                                                                              case '':
                                                                                                                                    switch($_SERVER['REQUEST_METHOD']){
                                                                                                                                          case 'GET':
                                                                                                                                                      require_once('review_comments.php');
                                                                                                                                                      getSpecificReviewComment($command[$addr_offset+5]);
                                                                                                                                                      break;
                                                                                                                                          case 'PUT':
                                                                                                                                                      require_once('review_comments.php');
                                                                                                                                                      $newReviewComment = json_decode(file_get_contents('php://input'),true);
                                                                                                                                                      modifyReviewComment($command[$addr_offset+5],$newReviewComment);
                                                                                                                                                      break;
                                                                                                                                          case 'DELETE':
                                                                                                                                                      require_once('review_comments.php');
                                                                                                                                                      deleteReviewComment($command[$addr_offset+5]);
                                                                                                                                                      break;
                                                                                                                                    }
                                                                                                                                    break; //end of case ''
                                                                                                                              case 'delete':
                                                                                                                                    require_once('review_comments.php');
                                                                                                                                    deleteReviewComment($command[$addr_offset+5],$command[$addr_offset+7],$command[$addr_offset+8]);
                                                                                                                                    break;
                                                                                                                        }
                                                                                                                        break;
                                                                                                            }
                                                                                                            break; //end of case comments
                                                                                                }
                                                                                                break;     //end of switch($command[addr_offset +4]):
                                                                                    }
                                                                        break;      //end of case review
                                                            default: 
                                                                         break;     //case default /api/modules/module_code
                                                }
                                                break;      //end of switch($command[addr_offset +2])
                        }
                        break; // end of switch($command[$addr_offset+1])

            default:
                        break;
}     //end of switch($command[$addr_offset+0])
?>