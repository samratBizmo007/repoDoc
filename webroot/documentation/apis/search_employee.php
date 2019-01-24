<h1 id="search_employee">Search Employee</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>searchProviderLists.json</h4>
							</div>
							<!-- REQUEST RESPONSE FORMAT -->
							<div class="highlight boderleft">
								<h4 class="colorblue">Supported Formats</h4>  
								<code class="colorblue">JSON</code>
								<code class="colorblue">XML</code>
								<br><br>
								<p class="colorred">*Default Response is in JSON</p>
							</div>

							<!-- REQUEST METHOD -->
							<h3 id="type30">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input30">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token:00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJob3NwaXRhbF9pZCI6MSwidGVhbV9uYW1lIjoiR29sZCIsInBhdGllbnRfaWQiOjQ4fQ.mIjCil5mTLRGl1sY5EJnQ_0TwU_Ct2jL8LYz5ZwPDGs
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output30">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7ImVtcGxveWVlX2xpc3RzIjpbeyJ0ZWFtX2lkIjoxMSwidGVhbV9uYW1lIjoiR29sZCAxIiwiZW1wbG95ZWVzIjpbeyJlbXBsb3llZV9pZCI6MjA0LCJlbXBsb3llZV9uYW1lIjoiZmlyc3RuYW1lIEt1YmlsdXMiLCJlbXBsb3llZV9waG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZW1wbG95ZWVfZGVzaWduYXRpb24iOiJDaGFpciBPZiBUaGUgRGVwYXJ0bWVudCIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifSx7ImVtcGxveWVlX2lkIjoyMDYsImVtcGxveWVlX25hbWUiOiJBbGZvbnpvIE1laGlzIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiUHJvZmVzc29yIiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiZW1wbG95ZWVfaWQiOjM1OSwiZW1wbG95ZWVfbmFtZSI6IkRpcGVuIFBhdGVsIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiQXNzaXN0YW50IFByb2Zlc3NvciIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifSx7ImVtcGxveWVlX2lkIjozNjEsImVtcGxveWVlX25hbWUiOiJDaGludGFuIFJhZ2h3YW5pIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiQXNzaXN0YW50IFByb2Zlc3NvciIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifSx7ImVtcGxveWVlX2lkIjozNjIsImVtcGxveWVlX25hbWUiOiJKYXZpZCBQaXBhcmFuaSIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6IkFzc2lzdGFudCBQcm9mZXNzb3IiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiSW50ZXJuYWwgTWVkaWNpbmUiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIn0seyJlbXBsb3llZV9pZCI6MzY0LCJlbXBsb3llZV9uYW1lIjoiSmF2aWRqaSBQaXByYW5pamkiLCJlbXBsb3llZV9waG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZW1wbG95ZWVfZGVzaWduYXRpb24iOiJBc3NvY2lhdGUgUHJvZmVzc29yIiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6Ik5lcGhyb2xvZ3kiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIn0seyJlbXBsb3llZV9pZCI6MzY1LCJlbXBsb3llZV9uYW1lIjoiQ2hpbnRhbnNldGggcmFnaHdhbmlzZXRoIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiRGlyZWN0b3IiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiSW50ZXJuYWwgTWVkaWNpbmUiLCJlbXBsb3llZV9yb2xlIjoiT2NjdXBhdGlvbmFsIFRoZXJhcHkiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiT1QifSx7ImVtcGxveWVlX2lkIjozNjgsImVtcGxveWVlX25hbWUiOiJDaGludGFuUiBSYWdod2FuaSIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6IlByb2Zlc3NvciIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJOdXJzaW5nIFN0dWRlbnQiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiTlMifSx7ImVtcGxveWVlX2lkIjozNjksImVtcGxveWVlX25hbWUiOiJKYXZpZFAgUGlwcmFuaSIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6IkFzc2lzdGFudCBQcm9mZXNzb3IiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiTmV1cm9sb2d5IiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiZW1wbG95ZWVfaWQiOjM3MCwiZW1wbG95ZWVfbmFtZSI6IkFyeWFuIFJhdGhvZCIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6IkFzc29jaWF0ZSBQcm9mZXNzb3IiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiUmhldW1hdG9sb2d5IiwiZW1wbG95ZWVfcm9sZSI6Ik9jY3VwYXRpb25hbCBUaGVyYXB5IiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6Ik9UIn0seyJlbXBsb3llZV9pZCI6MzQ1LCJlbXBsb3llZV9uYW1lIjoiVmlldCBQaGFtIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiSG9zcGl0YWxpc3QiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiSW50ZXJuYWwgTWVkaWNpbmUiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIn1dfSx7InRlYW1faWQiOjEyLCJ0ZWFtX25hbWUiOiJHb2xkIDIiLCJlbXBsb3llZXMiOlt7ImVtcGxveWVlX2lkIjozMzksImVtcGxveWVlX25hbWUiOiJIYXlsZXkgRW1tZXIiLCJlbXBsb3llZV9waG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZW1wbG95ZWVfZGVzaWduYXRpb24iOiJTdXBlcnZpc2VyIiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkFkbWluaXN0cmF0aW9uIiwiZW1wbG95ZWVfcm9sZSI6IlN1cGVydmlzZXIiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiU1UifSx7ImVtcGxveWVlX2lkIjoyMDUsImVtcGxveWVlX25hbWUiOiJBYXJvbiBXaWNrc3Ryb20iLCJlbXBsb3llZV9waG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZW1wbG95ZWVfZGVzaWduYXRpb24iOiJQcm9mZXNzb3IiLCJlbXBsb3llZV9kZXBhcnRtZW50IjoiSW50ZXJuYWwgTWVkaWNpbmUiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIn0seyJlbXBsb3llZV9pZCI6MjA3LCJlbXBsb3llZV9uYW1lIjoiQWxmcmVkIENoYXJ0cmF3IiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiQXNzaXN0YW50IFByb2Zlc3NvciIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifSx7ImVtcGxveWVlX2lkIjozNjcsImVtcGxveWVlX25hbWUiOiJjaGludGFudGhyZWUgcmFnaHdhbml0aHJlZSIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6IkRpcmVjdG9yIiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiZW1wbG95ZWVfaWQiOjM3MSwiZW1wbG95ZWVfbmFtZSI6IkNyeXN0YWwgRHNvdXphIiwiZW1wbG95ZWVfcGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImVtcGxveWVlX2Rlc2lnbmF0aW9uIjoiTWVkaWNhbCBTdHVkZW50IiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkZhbWlseSBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJSZWdpc3RlcmVkIE51cnNlIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IlJOIn0seyJlbXBsb3llZV9pZCI6MzQ0LCJlbXBsb3llZV9uYW1lIjoiS2hhbmR1cmFvIEtob3QiLCJlbXBsb3llZV9waG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZW1wbG95ZWVfZGVzaWduYXRpb24iOiJIb3NwaXRhbGlzdCIsImVtcGxveWVlX2RlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifV19XX19.aBbOwMaoeqR0RBYlunJi55QLtlbwFWMO6UGU-kISVqQ"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>