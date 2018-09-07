<head>
<style>
				.dropbtn {
    			 		 font-size: 16px;
    					 border: 3px solid black;
						 }
				.dropdown 
						{
    					position: relative;
    					display: inline-block;
    					float:left;
    					width:20%;
						}

				.dropdown-content 
						{
    					display: none;
    					position: absolute;
    					background-color: #f9f9f9;
    					min-width: 160px;
    					box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    					z-index: 1;
						}
/*
				.dropdown-content button 
						{
    					color: white;
    					font-weight: bold;
    					padding: 12px 16px;
    					text-decoration: none;
    					display: block;
						}


				.dropdown-content button:hover 
				        {background-color: #f1f1f1}


				.dropdown:hover .dropdown-content 
						{
    					display: block;
						}

*/
				.dropdown:hover .dropbtn 
						{
    					background-color: #3e8e41;
						}

				#cbox
				       {
				       	width:100px;
				       	height:700px;
                        position: relative;
				       	/*border:2px solid black;*/
				       }
				 #innermsgbox
				       {
				       width:100%;
				       }

</style>
<script>
	function showdrop()
	    { var stat=document.getElementById('c1').style.display;
	      if (stat=='none') document.getElementById('c1').style.display='block';
	      else document.getElementById('c1').style.display='none';
	    	//document.getElementById('c1').style.display='block';
	    }
</script>
</head>

<body>
      <div class="dropdown">
  		<button class="dropbtn" onclick="showdrop()"> <h3>Chat Window</h3></button>
  			<div class="dropdown-content"  id='c1'>
    		<b1 id='cbox'>
    		  <ib>
    		This is the space for a chat window that is being planned to be implemented right here the text is not expected to overflow
    		  </ib>
    		  <ib2 id='innermsgbox'>
    		  		<input type='text' id='chatinp' name='chatinp'>

    		  </ib2>
    		</b1>
  			</div>
	  </div>
	  
</body>