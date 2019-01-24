<h1 id="patient_view_notes">Patient View Notes</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>patientViewNotes.json</h4>
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
							<h3 id="type9">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input9">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : 00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbXBsb3llZV9pZCI6NzMsInBhdGllbnRfaWQiOjMzfQ.-M6woBH4oyhlW-cOEOSD8SdhE7nvnBcCQEYHkA0YUoQ
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output9">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7Im5vdGVzIjp7ImlkIjoxMTgsImVtcGxveWVlX2lkIjo3MywiY29udGVudCI6ImtqaGxzanNqc1xuanNqc2pzIiwidGltZXN0YW1wIjowLCJwYXRpZW50X2lkIjozM30sInJlbWluZGVycyI6W3siaWQiOjcwLCJlbXBsb3llZV9pZCI6NzMsImNvbnRlbnQiOiJraiIsImRhdGUiOiIwOC0wNi0xOCIsInRpbWUiOiIxMToyOSBwbSIsInN0YXR1cyI6dHJ1ZSwibmFtZSI6IkhhZSBGb2x0YSIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJkZXNpZ25hdGlvbiI6IkRpcmVjdG9yIiwiZGVwYXJ0bWVudCI6IlBoeXNpY2FsIFRoZXJhcHkiLCJlbXBsb3llZV9yb2xlIjoiUGh5c2ljYWwgVGhlcmFweSIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJQVCJ9LHsiaWQiOjY5LCJlbXBsb3llZV9pZCI6NzMsImNvbnRlbnQiOiJrIiwiZGF0ZSI6IjA4LTA2LTE4IiwidGltZSI6IjExOjI3IHBtIiwic3RhdHVzIjp0cnVlLCJuYW1lIjoiSGFlIEZvbHRhIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImRlc2lnbmF0aW9uIjoiRGlyZWN0b3IiLCJkZXBhcnRtZW50IjoiUGh5c2ljYWwgVGhlcmFweSIsImVtcGxveWVlX3JvbGUiOiJQaHlzaWNhbCBUaGVyYXB5IiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IlBUIn1dfX0.iNmn-P-StI_s71_XbNS0EqcoZcb3P1T0MhEFTDlCW8Q"
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

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6Ik9vcHMgISBTb21ldGhpbmcgd2VudCB3cm9uZy4ifQ.Wb-KLc0jy7_FDdXCK0NsbXNSxU0kgw7fBgjRRk4jUSE"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>