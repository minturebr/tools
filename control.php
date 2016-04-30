<?php
	set_time_limit(0); 

	@$address = $argv[1];
	@$port = $argv[2];

	if (empty ($address) AND empty ($port)) {
		print "You need to configure IP and Port to listen\n";
		print " Example : php control.php 192.168.1.200 2222\n";
	} else {
		if (strlen($address) < 4) {
			print "Invalid address!\n";
		} elseif(strlen($port) < 1) {
			print "Invalid port!\n";
		} else {
			print "Waiting for connection...\n";

			$sock = socket_create(AF_INET, SOCK_STREAM, 0);
			$bind = socket_bind($sock, $address, $port);
	
			socket_listen($sock);
	
			while (true) {
				$client = socket_accept($sock);
				$input = socket_read($client, 2048);
		
				$peername = socket_getpeername($client, $a, $r);	

				print "\nReceived Connection from $a:$r\n";

				print "\n$input\n";
		
				while (true) {
					print "Command : ";
					$send = trim(fgets(STDIN, 1024));
					$send = trim("\n$send");
					socket_write($client, $send);
					socket_shutdown($client, 1);
					print "\nSent!-> $send\n";
					$client = socket_accept($sock);
				}
			}
		}
	}
?>
