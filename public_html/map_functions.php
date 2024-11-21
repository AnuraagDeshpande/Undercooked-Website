
        <?php
            /*Here we fetch the data using an API call inside the exec command*/

            //This function gets the command with the ip address
            function getCommand($ip){
                $command ="curl \"ipinfo.io/$ip?token=c5ce36c2e7b896\"";
                return $command;
            }
            //this function returns the coordinates of a given IP address
            function getLoc($ip){
                $output="";
                $command = getCommand($ip);
                $result_code;
                $cord;
                //we execute the command:
                exec($command, $output, $result_code);
                //we concatenate the strings and fetch data
                $jsonString = implode("", $output);
                $data = json_decode($jsonString, true);
                //check that coordinate are there:
                if (isset($data['loc'])) {
                    $location = $data['loc'];
                    return $location;
                } else {
                    echo "Location field not found.\n";
                    return null;
                }
                
            }
            //get Ips of all user from logs
            function getIps(){
                $ips=[];//array with ips

                $log = file_get_contents("request.json");
                //split the file content into lines
                $log_lines = explode("\n", $log);

                //we iterate through each line
                foreach ($log_lines as $line) {
                    //trim whitespace from the line
                    $line = trim($line);
                    if (!empty($line)) {
                        //decode the JSON line
                        $log_json = json_decode($line, true);

                        //check if the JSON was decoded successfully
                        if ($log_json !== null) {
                            $log_ip = $log_json['ip'];
                            if(!in_array($log_ip, $ips) && $log_ip!="::1"){
                                $ips[] = $log_ip;
                            }
                        } else {
                            echo "Invalid JSON in line: $line<br>";
                        }
                    }
                }
                return $ips;
            }
            //get location of current user
            function getUserLoc(){
                $ip = $_SERVER ['REMOTE_ADDR'];
                return getLoc($ip);
            }
            //get the locations of all users from logs
            function getLocs(){
                $ips=getIps();
                $locs=[];
                foreach($ips as $ip){
                    $locs[]=getLoc($ip);
                }
                return $locs;
            }
        ?>
