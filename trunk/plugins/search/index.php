<script type="text/javascript" language="javascript">

function btnSearch_onclick(){

	if(test_empty(document.formSearch.keyword.value)){

		alert(mustInput_Search);document.formSearch.keyword.focus();return false;

	}

	document.formSearch.submit();

	return true;

}

</script>
          <form id="formSearch" name="formSearch" method="post" action="<?=$curHost?>" >
   	        <input type="hidden" name="act" value="search" />
	        <input type="hidden" name="frame" value="search" />

            <input name="keyword" id="keyword" class="art-button" type="text" onfocus="this.value=''" value="<?php
                if($_lang=="vn") echo "Nhập từ khóa..."; 
                else if($_lang=="en") echo "Enter key..."; 
                else echo "回車鍵...";
            ?>
            " style="background:url('<?=$curHost?>images/bg_search.png') no-repeat; line-height:31px; height:31px; width:238px; border:none;padding-left: 25px; color:#FFF;" />
            <input class="art-button" type="submit" value="<?=_SEARCH?>" style="visibility:hidden" />
          </form>
