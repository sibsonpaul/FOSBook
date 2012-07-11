<?php 



/** 
 * The Class
 */
class PersonMetaBox
{
    const LANG = 'some_textdomain';
	private $Id = "";

    public function __construct($ID)
    {
		$this->Id=$ID;
		
		
        add_action( 'add_meta_boxes', array( &$this, 'add_person_meta_box' ) );
		
    }

    /**
     * Adds the meta box container
     */
    public function add_person_meta_box()
    {
		$person= new Person($this->Id);
		$name = $person->returnName();
        add_meta_box( 
             'person_detail'
            ,__( $name, self::LANG )
            ,array( &$this, 'render_person_meta_box_content' )
            ,'post' 
            ,'advanced'
            ,'high'
        );
    }


    /**
     * Render Meta Box content
     */
    public function render_person_meta_box_content() 
    {
        echo '<a href="'.get_bloginfo('url').'?Id='.$this->Id.'" rel="external"><dt class="person">'.$PersonImage.' <span class="name">' . $label . '</span></dt><dd class="person format_text"></dd></a>';
    }
}



?>