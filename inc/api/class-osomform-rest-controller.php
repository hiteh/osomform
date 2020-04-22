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
  * Valid fields list.
  * @var mixed OsomformRepository
  */
  protected $fields = array(
    'first_name' => 'not_provided',
    'last_name' => 'not_provided',
    'login' => 'not_provided',
    'email' => 'not_provided',
    'city' => 'not_provided',
  );

  /**
   * Class constructor
   *
   * @param OsomformRepositoryInterface $repository Data repository.
   */
  public function __construct( OsomformRepositoryInterface $repository ) {
    $this->namespace = 'osomform/v1';
    $this->rest_base = 'osomcontact';
    $this->repository = $repository;
  }

  /**
   * Register the routes for the objects of the controller.
   */
  public function register_routes() {
    
    register_rest_route( $this->namespace, '/' . $this->rest_base, array(
      array(
        'methods'  => WP_REST_Server::READABLE,
        'callback' => array( $this, 'get_items' ),
        'permission_callback' => array( $this, 'get_items_permissions_check' ),
      ),
      array(
        'methods'  => WP_REST_Server::CREATABLE,
        'callback' => array( $this, 'create_item' ),
        'permission_callback' => array( $this, 'create_item_permissions_check' ),
        'args' => array(
          'first_name' => array(
            'required' => true,
          ),
          'last_name' => array(
            'required' => true,
          ),
          'login' => array(
            'required' => true,
          ),
          'email' => array(
            'required' => true,
          ),
          'city' => array(
            'required' => true,
          ),
        ),
      ),
      'schema' => [ $this, 'get_collection_params' ],
    ) );
  }

  /**
   * Check if a given request has access to get items
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   */
  public function get_items_permissions_check( $request ) {
    return current_user_can( 'manage_options' );
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

    if ( is_array( $data ) ) {
      return rest_ensure_response( $data );
    }

    return new WP_Error( 'cant-get-items', __( 'message', 'osomform' ), array( 'status' => 500 ) );
  }
 
  /**
   * Create one item from the collection
   *
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   */
  public function create_item( $request ) {

    $item = $this->prepare_item_for_database( $request );
    $id = $this->repository->create( $item );
    
    if ( is_int( $id ) ) {
      return rest_ensure_response( ['message' => __( 'Formularz zapisany.', 'osomform' )] );
    }

    return new WP_Error( 'cant-create', __( 'message', 'osomform' ), array( 'status' => 500 ) );
 
  }
 
  /**
   * Prepare the item for create or update operation
   *
   * @param WP_REST_Request $request Request object
   * @return WP_Error|object $prepared_item
   */
  protected function prepare_item_for_database( $request ) {

    extract( $this->fields );
    extract( $request->get_body_params(), EXTR_IF_EXISTS );
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
    return array(
        '$schema'  => 'http://json-schema.org/draft-04/schema#',
        'title'    => 'osomcontact',
        'type'     => 'object',
        'required' => [ 'first_name', 'last_name', 'login', 'email', 'city' ],
        'properties'           => array(
            'id' => array(
                'description'  => esc_html__( 'Unique identifier for the user.', 'osomform' ),
                'type'         => 'integer',
                'readonly'     => true,
            ),
            'first_name' => array(
                'description'  => esc_html__( 'First name of the user.', 'osomform' ),
                'type'         => 'string',
                'required'     => true,
            ),
            'last_name' => array(
                'description'  => esc_html__( 'Last name of the user.', 'osomform' ),
                'type'         => 'string',
                'required'     => true,
            ),
            'login' => array(
                'description'  => esc_html__( 'Login of the user.', 'osomform' ),
                'type'         => 'string',
                'required'     => true,
            ),
            'email' => array(
                'description'  => esc_html__( 'E-mail address of the user.', 'osomform' ),
                'type'         => 'string',
                'format'       => 'email',
                'required'     => true,
            ),
            'city' => array(
                'description'  => esc_html__( 'City of the user.', 'osomform' ),
                'type'         => 'string',
                'required'     => true,
            ),
            'submitted_at' => array(
                'description'  => esc_html__( 'The date form was submitted at.', 'osomform' ),
                'type'         => 'string',
                'readonly'     => true,
            ),
        ),
    );
  }

}

/**
 * Register api routes
 *
 */
if( ! function_exists( 'osomform_register_rest_routes' ) ) {
  
  function osomform_register_rest_routes() {

    $storage_type = get_option( 'osomform_store_type' );

    switch ( $storage_type ) {

      case 'file':
        $repository = new OsomformFileRepository();
        OsomformFileRepository::storage_setup();
        break;
      default:
        $repository = new OsomformDBRepository();
        OsomformDBRepository::storage_setup();
        break;
    }

    $controller = new Osomform_REST_Controller( $repository );
    $controller->register_routes();
  } 
}
