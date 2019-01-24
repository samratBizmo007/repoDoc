<h1 id="search_provider_lists">Search Provider Lists</h1>
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
							<h3 id="type5">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input5">Input</h3>
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
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJob3NwaXRhbF9pZCI6MSwicHJvdmlkZXJfbmFtZSI6ImtoIiwiZGVwYXJ0bWVudCI6IkRSIiwicm9vbSI6IjEtNTAxIiwiZW1wbG95ZWVfaWQiOjI3NX0.zDJEL1InApO54CX_LZVo2s9oU0J5Q4GTa0O2w4BJCKY
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output5">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6MzQ0LCJuYW1lIjoiS2hhbmR1cmFvIEtob3QiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZGVzaWduYXRpb24iOiJIb3NwaXRhbGlzdCIsImRlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIiLCJpc193b3JraW5nIjowLCJkZXZpY2VfdG9rZW4iOiIiLCJkZXZpY2VfdHlwZSI6MSwiYmVkIjoiMS01MDEifSx7ImlkIjozNDIsIm5hbWUiOiJKYW5ha2kgS2hvdCIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJkZXNpZ25hdGlvbiI6IkRpcmVjdG9yIiwiZGVwYXJ0bWVudCI6IkNhcmRpb2xvZ3kiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIiwiaXNfd29ya2luZyI6MCwiZGV2aWNlX3Rva2VuIjoiZUFNbEhhSWpSZXc6QVBBOTFiRnQ0Nzg1Y3lweG9PbWpZcXlJb05MTGsxZUhZb05zek1EV1dCLThwbHE2ZmdoV1Mwd1hCX2k1dmFld2d2RGYtci1JTFVUTmEwbXp1aGVZRHRXbkxnbWsxUkEtNUIwWU5OVEtsTVZRYkxlM0pGM0V0OTNUdEFFcVE4WHExNXJBMm1hTF9xbW4iLCJkZXZpY2VfdHlwZSI6MiwiYmVkIjoiMS01MDEifSx7ImlkIjozNjAsIm5hbWUiOiJLYiBLaG90IiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImRlc2lnbmF0aW9uIjoiSG9zcGl0YWxpc3QiLCJkZXBhcnRtZW50IjoiSW50ZXJuYWwgTWVkaWNpbmUiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIiwiaXNfd29ya2luZyI6MCwiZGV2aWNlX3Rva2VuIjoiY0JxYTNzUDExMWc6QVBBOTFiRkUtN3Y4S2g4RzZtbGRvSHZkTkdIb2Zrd0tQakR3WlpCUnBNX25neDlYZWt2R0pnRE5FWEZjQmxIeHhvcWQySzN0dGJrSms0eU5OcnRaelpUdVoySHF4QkhHLW5EbnE1X1hkTkZWcFFLdks3SmJ3VFZnbDA5ck5FenFSOXFVN25jbkNPSGwiLCJkZXZpY2VfdHlwZSI6MiwiYmVkIjoiMS01MDEifV19.T12SopQW-wBeXkAI6cP6yy-bAWY27_TGuSBdPD784rc"
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