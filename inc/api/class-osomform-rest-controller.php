<?php
 /**
 * Theme rest controller
 *
 * @package osomform
 * @since Osom Form 1.0
 * @version 1.0
 */

class Osomform_REST_Controller extends WP_REST_Controller {
 
  /**
  * Repository interface.
  * @var mixed OsomformRepository
  */
  protected $repository; 

  /**
   * Class constructor
   *
   * @param OsomformRepositoryInterface $repository Data repository.
   */
  public function __construct( OsomformRepositoryInterface $repository ) {
    $this->repository = $repository;
  }

  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {
    register_rest_route( 'osomform/v1', '/osomcontact', array(
      array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => array( $this, 'get_items' ),
        'permission_callback' => array( $this, 'get_items_permissions_check' ),
      ),
      array(
        'methods'  => WP_REST_Server::CREATABLE,
        'callback' => array( $this, 'create_item' ),
        'permission_callback' => array( $this, 'create_item_permissions_check' ),
      ),
    ) );
  }


  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_items_permissions_check( $request ) {
    return true;
  }

  /**
   * Check if a given request has access to create items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function create_item_permissions_check( $request ) {
    return true;
  }

 
  /**
   * Get a collection of items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function get_items( $request ) {
    $data = $this->repository->readAll();
    return rest_ensure_response( $data );
  }
 
  /**
   * Create one item from the collection
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function create_item( $request ) {

    $item = $this->prepare_item_for_database( $request );
    $data = $this->repository->create( $item );
    
    if ( is_array( $data ) ) {
      return rest_ensure_response( ['message' => __( 'Formularz zapisany.', 'osomform' )] );
    }
 
  }
 
  /**
   * Prepare the item for create or update operation
   *
   * @param WP_REST_Request $request Request object
   * @return WP_Error|object $prepared_item
   */
  protected function prepare_item_for_database( $request ) {
    $first_name = 'not_provided';
    $last_name = 'not_provided';
    $login = 'not_provided';
    $email = 'not_provided';
    $city = 'not_provided';
    extract( $request, EXTR_IF_EXISTS );
    return array(
      'first_name'   => sanitize_text_field( trim( $first_name ) ),
      'last_name'    => sanitize_text_field( trim( $last_name ) ),
      'login'        => sanitize_text_field( trim( $login ) ),
      'email'        => sanitize_text_field( trim( $email ) ),
      'city'         => sanitize_text_field( trim( $city ) ),
      'submitted_at' => current_time( 'mysql', true )
    );
  }
 
  /**
   * Get the query params for collections
   *
   * @return array
   */
  public function get_collection_params() {

  }

}

// Register api routs.
if( ! function_exists( 'osomform_register_rest_routes' ) ) {
  
  function osomform_register_rest_routes() {
    global $controller;
    $controller->register_routes();
  } 
}