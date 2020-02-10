
    /**
     *  Selects, deselects all the checkboxes inside a given DOM reference
     *  Used in the admin edit/create view      
     */         
	function chk_selector( way, obj )
	{
        var block = obj.parentNode;
        var chks = block.getElementsByTagName('input');
        
        for ( i=0; i<chks.length; i++ )
        {
            if( chks[i].type == 'checkbox' )
            {
                if( way == 'all' )
                {
                    chks[i].checked = true;
                }
                else if( way == 'none' )
                {
                    chks[i].checked = false;
                }
            }
        }		
	}

    /**
     *  General confirm message used to check wether the user really wants to delete a row
     *  Used in the listings view
     */
    function chk( url )
    {
        if( confirm('Biztos törölni akarja a ezt a sort?') )
        {
            document.location = url;
        }
    }
    function elfogad( url )
    {
        if( confirm('Biztos elfogadja a témát?') )
        {
            document.location = url;
        }
    }
    function elutasit( url )
    {
        if( confirm('Biztos elutasítja a témát?') )
        {
            document.location = url;
        }
    }
    function promote( url )
    {
        if( confirm('Biztos véglegesen elfogadja a témát?') )
        {
            document.location = url;
        }
    }
    /**
     *  Initialize widgets on page load
     */
    $( document ).ready( function()
    {
        /**
         *  WYSIWYG EDITOR
         */
        $.cleditor.buttons.image.uploadUrl = 'uploads';
        $('.wysiwyg').cleditor(
        {
            width:      "100%",
            controls:   "bold italic underline strikethrough | style | " +
                        "bullets numbering | outdent " +
                        "indent | alignleft center alignright | undo redo removeformat | " +
                        "rule image link unlink | pastetext | source"

            // more options at: 
            // http://premiumsoftware.net/cleditor/docs/GettingStarted.html#optionalParameters
        });

        /**
         *  DATEPICKER
         */
        $('.datepicker').datepicker();

        /**
         *  Add security confirm for the multi delete button
         */
        $('.actions button').click( function( event )
        {
            if( !confirm('Biztos törölni akarja a kiválasztott sorokat?') )
            {
                event.preventDefault();
            }       
        });
    });
