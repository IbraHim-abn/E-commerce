<?php 
/* Array 
$language = array('GO' => 'ذهب','wait'=>'انتظر'); echo $language['wait'];
*/
function lang( $phrase ){
    static $lang = array(

             //Words of dashboard page
             //Navbar words
        'Home'           =>  'Home' , 
        'CATC'           =>  'Categories' ,
        'ITEMS'          =>  'Items',
        'MEMBERS'        =>  'Members',
        'COMMENTS'       =>  'Comments' ,
        'STATISTICS'     =>  'Statistics',
        'LOGS'           =>  'Logs',
        'Edit_Profile'   =>  'Edite Profile' ,
        'Settings'       =>  'Settings' ,
        'LogOut'         =>  'Log out' ,
        'VISITSHOP'      =>  'Visit Shop'


                        );
                        
                        return $lang[$phrase];
}

?>