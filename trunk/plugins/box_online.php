<div class="left-right" style="width:25%;float:left;">
    <div class="right-right" style="color:#8e774d;font-size:1.3em;margin-left:3px;width:60%;float:right;padding-left:10%;padding-bottom:10px;">
    <?
    $sql = "select * from yahoo_sky where active=0";
    $result = mysql_query($sql,$conn);
    if(!empty($result))
    while($row=mysql_fetch_assoc($result)){
    ?>
        <a href="ymsgr:sendIM?<?=$row['username']?>">
            <img border="0" src="http://mail.opi.yahoo.com/online?u=<?=$row['username']?>&m=g&t=2" alt="<?=$row['name']?>">
        </a>
    
    <? }?>
    </div>
</div>
                                        <div   style="width:98%;float:left;color:#232323;font-size:1.2em;text-align:center;padding-bottom:10px;">
                                        	Hotline 1: 01254532322
                                        </div>    
                                          <div   style="width:98%;float:left;color:#232323;font-size:1.2em;text-align:center;padding-bottom:10px;">
                                        	Hotline 2: 01254536322
                                        </div>       
                                          <div   style="width:88%;float:left;color:#232323;font-size:1.2em;text-align:left;padding-bottom:10px;padding-left:10%;">
                                        	Email: thanhhomay@gmail.com
                                        </div>     
                                          <div   style="width:98%;float:left;color:#232323;font-size:1.2em;text-align:center;padding-bottom:10px;">
                                        	FAX: 01254536322
                                        </div> 