
<label id="lbldata"></label>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pako/1.0.11/pako_inflate.js"></script>
<script type="text/javascript">

		var feed_token = '<?= $feed_token ?>';
		var client_code = '<?= $client_code ?>';
		var strwatchlistscrips = '<?= $script ?>';//"nse_cm|2885&nse_cm|1594&nse_cm|11536";
		var task = '<?= $task ?>';
		//console.log(feed_token+' '+client_code+' '+ strwatchlistscrips);
		//var conn = new WebSocket('ws://omnesys.angelbroking.com/NestHtml5Mobile/socket/stream');
		var conn = new WebSocket('wss://omnefeeds.angelbroking.com/NestHtml5Mobile/socket/stream');
		conn.onopen = function(e) { 

			var _req = '{"task":"cn","channel":"","token":"' + feed_token + '","user":"' + client_code + '","acctid":"' + client_code + '"}'; 
			//var _req = '{"task":"cn","channel":"","token":"0967696573","user":"D883","acctid":"D883"}'; 
			
			conn.send(_req);

			
            var _req = '{"task":"'+task+'","channel":"' + strwatchlistscrips + '","token":"' + feed_token + '","user": "' + client_code + '","acctid":"' + client_code + '"}';
            //console.log(_req)
            conn.send(_req);

            setInterval(function () {
                 var _hb_req = '{"task":"hb","channel":"","token":"' + feed_token + '","user": "' + client_code + '","acctid":"' + client_code + '"}';
                 conn.send(_hb_req);
            }, 60000);
		}; 
		conn.onmessage = function(e) {
			 
		 let strData = atob(e.data);

           // Convert binary string to character-number array
           var charData = strData.split('').map(function (x) { return x.charCodeAt(0); });

           // Turn number array into byte-array
           var binData = new Uint8Array(charData);

           // Pako magic
           var result = _atos(pako.inflate(binData));
		    
		    console.log(result);
		    document.getElementById('lbldata').innerHTML  += '<br/><br/>Receive stock ticks::<br/>'+result;
		};
		
		
		  conn.onerror = function (evt) {
               console.log("error::", evt)
              
          };
          conn.onclose = function (evt) {
          	    console.log("Socket closed")
               //conn.connect();
           };

		function _atos(array) {
		     var newarray = [];
		     try {
		          for (var i = 0; i < array.length; i++) {
		               newarray.push(String.fromCharCode(array[i]));
		          }
		     } catch (e) { }

		     return newarray.join('');
		}
</script>
