<?php 
/* Array 
$language = array('GO' => 'ذهب','wait'=>'انتظر'); echo $language['wait'];
*/
function lang( $phrase ){
    static $lang = array(

             //Words of dashboard page 
        'Home'           =>  'الرئيسية' , 
        'CATC'           =>  'التصنيف' ,
        'Edit_Profile'   =>  'تعديل الملف الشخصي' ,
        'Settings'       =>  'الإعدادات' ,
        'LogOut'         =>  'تسجيل الخروج'


                        );
                        
                        return $lang[$phrase];
}

?>