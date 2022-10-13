var position = 0;
var length = 5;
const cron = require("node-cron");
if (  position<= length)
{
position+=1;
cron.schedule("5 * * * * *",function(){
    console.log("5 second have pass")
})


}