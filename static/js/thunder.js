<html>
      
</head>
      
<script type="text/javascript">
         
//初始化迅雷插件
         
function InitialActiveXObject()
         
{  
         
   var Thunder;
         
   try
         
   {
         
      Thunder = new ActiveXObject("ThunderAgent.Agent")  
         
   }catch(e)
         
   {
         
     try
         
     {
         
       Thunder=new ActiveXObject("ThunderServer.webThunder.1");
         
     }catch(e)
         
     {
         
       try
         
       {
         
         Thunder = new ActiveXObject("ThunderAgent.Agent.1");
         
       }catch(e)
         
       {
         
         Thunder = null;
         
       }      
         
     }    
         
   }
         
   return Thunder;
         
}
         
//开始下载
         
function Download(url)
         
{
         
   var Thunder = InitialActiveXObject();
         
          
         
   if(Thunder == null)
         
   {
         
     DownloadDefault(url);
         
     return;
         
   }  
         
   try
         
   {     
         
      Thunder.AddTask(url,"","","","",1,1,10);
         
      Thunder.CommitTasks();     
         
   }catch(e)
         
   {
         
      try
         
      {
         
          Thunder.CallAddTask(url,"","",1,"","");      
         
       }catch(e)
         
      {
         
        DownloadDefault(url);
         
      }       
         
   }
         
}
         
//容错函数，打开默认浏览器下载
         
function DownloadDefault(url)
         
{
         
  //alert('打开浏览器下载.......');
         
}
</script>