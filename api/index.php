<?php
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
//$requestURI = explode('/', $_REQUEST['url']);
//current api call starts with "localhost/corsview/api/..."

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
                                    case 'search':
                                          require_once('modules.php');
                                          $keyWord = json_decode(file_get_contents('php://input'), true);
                                          getModuleInfoForSearch($keyWord);
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

                                                            case 'documents':
                                                                        switch($command[$addr_offset+3]){
                                                                              case '':
                                                                                    switch($_SERVER['REQUEST_METHOD']){
                                                                                          case 'POST':
                                                                                                require_once('documents.php');
                                                                                                $documentDetails = json_decode(file_get_contents('php://input'),true);
                                                                                                addDocument($documentDetails);
                                                                                                break;
                                                                                          case 'GET':
                                                                                                require_once('documents.php');
                                                                                                getDocuments($command[$addr_offset+1]);
                                                                                                break;
                                                                                    }
                                                                                    break;
                                                                              default:    //document id exists
                                                                                          switch($command[$addr_offset+4]){
                                                                                                case '':
                                                                                                      switch($_SERVER['REQUEST_METHOD']){
                                                                                                                  case 'GET':
                                                                                                                        require_once('documents.php');
                                                                                                                        getSpecificDocument($command[$addr_offset+3]);
                                                                                                                        break;
                                                                                                                  case 'PUT':
                                                                                                                        require_once('documents.php');
                                                                                                                        $newDocument = json_decode(file_get_contents('php://input'),true);
                                                                                                                        modifyDocument($command[$addr_offset+3],$newDocument);
                                                                                                                        break;
                                                                                                                  default:
                                                                                                                        break;
                                                                                                      }
                                                                                                      break;
                                                                                                case 'delete':
                                                                                                                  require_once('documents.php');
                                                                                                                  deleteDocument($command[$addr_offset+3],$command[$addr_offset+5],$command[$addr_offset+6]);
                                                                                                      break;
                                                                                                case 'votes':
                                                                                                                  require_once('documents.php');
                                                                                                                  $vote= json_decode(file_get_contents('php://input'),true);
                                                                                                                  documentVote($vote);
                                                                                                      break;
                                                                                                case 'comments':
                                                                                                            switch($command[$addr_offset+5]){
                                                                                                                  case '':
                                                                                                                        switch($_SERVER['REQUEST_METHOD']){

                                                                                                                              case 'POST':
                                                                                                                                          require_once('document_comments.php');
                                                                                                                                          $newReviewComment = json_decode(file_get_contents('php://input'),true);
                                                                                                                                          //print_r($newReviewComment);
                                                                                                                                          postDocumentComment($newReviewComment);
                                                                                                                                          break;
                                                                                                                              case 'GET':
                                                                                                                                          require_once('document_comments.php');
                                                                                                                                          getComments($command[$addr_offset+3]);
                                                                                                                                          break;
                                                                                                                        }
                                                                                                                        break;
                                                                                                                  default: // comment id exists
                                                                                                                        switch($command[$addr_offset+6]){
                                                                                                                              case '':
                                                                                                                                    switch($_SERVER['REQUEST_METHOD']){
                                                                                                                                          case 'GET':
                                                                                                                                                      require_once('document_comments.php');
                                                                                                                                                      getSpecificDocumentComment($command[$addr_offset+5]);
                                                                                                                                                      break;
                                                                                                                                          case 'PUT':
                                                                                                                                                      require_once('document_comments.php');
                                                                                                                                                      $newDocumentComment = json_decode(file_get_contents('php://input'),true);
                                                                                                                                                      modifyReviewComment($command[$addr_offset+5],$newDocumentComment);
                                                                                                                                                      break;
                                                                                                                                    }
                                                                                                                                    break; //end of case ''
                                                                                                                              case 'delete':
                                                                                                                                    require_once('document_comments.php');
                                                                                                                                    deleteDocumentComment($command[$addr_offset+5],$command[$addr_offset+7],$command[$addr_offset+8]);
                                                                                                                                    break;
                                                                                                                        }
                                                                                                                        break;
                                                                                                            }
                                                                                                            break; //end of case comments
                                                                                    }
                                                                                    break; // end of  comments:switch($command[$addr_offset+4]){
                                                                        } 
                                                                        break;
                                                            default: 
                                                                         break;     //case default /api/modules/module_code
                                                }
                                                break;      //end of switch($command[addr_offset +2])
                        }
                        break; // end of switch($command[$addr_offset+1])
            case 'users':
                        switch($command[$addr_offset+1]){
                              case '':
                                    switch($_SERVER['REQUEST_METHOD']){
                                          case 'POST':
                                                require_once('users.php');
                                                $newUser = json_decode(file_get_contents('php://input'),true);
                                                userRegister($newUser);
                                                break;
                                          case 'PUT':
                                                require_once('users.php');
                                                $user = json_decode(file_get_contents('php://input'),true);
                                                userLogin($user);
                                                break;
                                          default:
                                                break;
                                    }
                                    break;

                              default: //user id exists
                                          switch($command[$addr_offset+2]){
                                                case '':
                                                      switch($_SERVER['REQUEST_METHOD']){
                                                            case 'GET':
                                                                  require_once('users.php');   

                                                                  getUserInfo($command[$addr_offset+1]);
                                                                  break;
                                                            case 'DELETE':
                                                                  require_once('users.php');
                                                                  userLogout($command[$addr_offset+1]); 
                                                                  break;
                                                      }
                                                      break;

                                                case 'reviews':
                                                      require_once('users.php');
                                                      getReviewsByUserId($command[$addr_offset+1]);
                                                      break;
                                                case 'enrollments':
                                                      switch($command[$addr_offset+3]){
                                                            case '':
                                                                  switch($_SERVER['REQUEST_METHOD']){
                                                                        case 'GET':
                                                                              require_once('users_modules.php');
                                                                              getModulesTaken($command[$addr_offset+1]);
                                                                              break;
                                                                        case 'POST':
                                                                              require_once('users_modules.php');
                                                                              $enrollmentsDetails = json_decode(file_get_contents('php://input'), true);
                                                                              addEnrollment($enrollmentsDetails);
                                                                              break;
                                                                        default:
                                                                              break;    
                                                                  }
                                                                  break; 
                                                            default: //enrollment id exists
                                                                  switch($_SERVER['REQUEST_METHOD']){
                                                                        case 'DELETE':
                                                                              require_once('users_modules.php');
                                                                              deleteEnrollment($command[$addr_offset+3],$command[$addr_offset+1],$command[$addr_offset+4]);
                                                                              break;
                                                                        }
                                                                  break;
                                                      }
                                                      break;
/*
                                                case 'enrollmentList':
                                                      switch($command[$addr_offset+3]){
                                                            case '':
                                                                  switch($_SERVER['REQUEST_METHOD']){
                                                                        case 'POST':
                                                                              require_once('users_modules.php');
                                                                              $enrollmentsDetailList = json_decode(file_get_contents('php://input'), true);
                                                                              addEnrollmentList($enrollmentsDetailList);
                                                                              break;
                                                                        default:
                                                                              break;    
                                                                  }
                                                                  break; 
                                                            default: 
                                                                  break;
                                                      }
                                                      break;
   */         
                                                case 'bookmarks':
                                                      switch($command[$addr_offset+3]){
                                                            case '':
                                                                  switch($_SERVER['REQUEST_METHOD']){
                                                                        case 'GET':
                                                                              require_once('users_modules.php');
                                                                              getModulesBookmarked($command[$addr_offset+1]);
                                                                              break;
                                                                        case 'POST':
                                                                              require_once('users_modules.php');
                                                                              $bookmarkDetails = json_decode(file_get_contents('php://input'), true);
                                                                              addBookmark($bookmarkDetails);
                                                                              break;
                                                                        default:
                                                                              break;    
                                                                  }
                                                                  break; // case ''
                                                                  
                                                            default:    //bookmark id exists
                                                                  switch($_SERVER['REQUEST_METHOD']){
                                                                        case 'DELETE':
                                                                              require_once('users_modules.php');
                                                                              deleteBookmark($command[$addr_offset+3],$command[$addr_offset+1],$command[$addr_offset+4]);
                                                                              break;
                                                                        }
                                                                  break;
                                                      }
                                                      break;

                                                default:
                                                      break;
                                    

                                          }
                                    break;
                        }
                        break;      //end of case users
            default:
                        break;
}     //end of switch($command[$addr_offset+0])
?>
