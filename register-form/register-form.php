<?php
/*
Plugin Name: register Form
Plugin URI:
Description: Friendly Description
Version: 1.0.0
Author: LWHH
Author URI:
License: GPLv2 or later
Text Domain: register-form
 */
add_action('register_form',function (){
    $first_name=$_POST["first_name"]??'';
    $last_name=$_POST["last_name"]??'';
    $phone_number=$_POST["phone_number"]??'';

   ?>
        <p>
    <label for="first_name">
        <?php
        _e("First Name","register-form")
        ?>
    </label>
    <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($first_name);?>">
        </p>
    <p>
        <label for="last_name">
            <?php
            _e("Last Name","register-form")
            ?>
        </label>
        <input type="text" name="last_name" id="last_name" value=" <?php echo esc_attr($last_name);?>">
    </p>
    <p>
        <label for="phone_number">
            <?php
            _e("Phone number","register-form")
            ?>
        </label>
        <input type="text" name="phone_number" id="phone_number" value=" <?php echo esc_attr($phone_number);?>">
    </p>
<?php
 });

add_filter("registration_errors",function ($errors, $sanitized_user_login, $user_email){
    if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ){
            $errors->add("First Name is Blank",__("First name cannot be blank","register-form"));
        }

    if(empty($_POST["last_name"]) || ! empty( $_POST['first_name'] )&& trim($_POST['last_name'] ) == ''){
            $errors->add("Last Name is blank",__("Last Name cannot be blank",'register-form'));
        }
    if(empty($_POST["phone_number"]) || ! empty( $_POST['phone_number'] )&& trim($_POST['phone_number'] ) == ''){
        $errors->add("Phone number is blank",__("Phone number cannot be blank",'register-form'));
    }
        return $errors;

},10,3);

add_action("user_register",function ($user_id){
    if ( ! empty( $_POST['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', sanitize_text_field( $_POST['first_name'] ) );
    }
    if ( ! empty( $_POST['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
    }
    if ( ! empty( $_POST['phone_number'] ) ) {
        update_user_meta( $user_id, 'phone_number', sanitize_text_field( $_POST['phone_number'] ) );
    }
});
function rgf_phone_meta_form_field( $user )
{
    ?>
    <h3>It's Your phone number</h3>
    <table class="form-table">
        <tr>
            <th>
                <label for="phone_number"><?php _e("Phone Number","register-form");?></label>
            </th>
            <td>
                <input type="text"
                       class="regular-text ltr"
                       id="phone_number"
                       name="phone_number"
                       value="<?= esc_attr( get_user_meta( $user->ID, 'phone_number', true ) ) ?>"
                       title="phone Number"
                       required>
                <p class="description">
                   <?php  _e("Please enter your Phone number.","register-form");?>
                </p>
            </td>
        </tr>
    </table>
    <?php
}
add_action(
    'show_user_profile',
    'rgf_phone_meta_form_field'
);

// Add the field to user profile editing screen.
add_action(
    'edit_user_profile',
    'rgf_phone_meta_form_field'
);




//ai gulo option tablbe er data edit er jonno

function rgf_update_phone_number_table_data( $user_id )
{
    // check that the current user have the capability to edit the $user_id
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    // create/update user meta for the $user_id
    return update_user_meta(
        $user_id,
        'phone_number',
        sanitize_text_field($_POST['phone_number'])
    );
}


add_action(
    'personal_options_update',
    'rgf_update_phone_number_table_data'
);

// Add the save action to user profile editing screen update.
add_action(
    'edit_user_profile_update',
    'rgf_update_phone_number_table_data'
);