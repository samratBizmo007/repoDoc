<h1 id="department_lists">Department Lists</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>get-department-lists.json</h4>
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
							<h3 id="type4">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>GET</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input4">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : 00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output4">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6MTA3LCJuYW1lIjoiSU0ifSx7ImlkIjoxMDgsIm5hbWUiOiJGTSJ9LHsiaWQiOjEwOSwibmFtZSI6IkdNIn0seyJpZCI6MTEwLCJuYW1lIjoiQ0FSRCJ9LHsiaWQiOjExMSwibmFtZSI6IkdJIn0seyJpZCI6MTEyLCJuYW1lIjoiUFVMTSJ9LHsiaWQiOjExMywibmFtZSI6IkNSSVQifSx7ImlkIjoxMTQsIm5hbWUiOiJORVBIIn0seyJpZCI6MTE1LCJuYW1lIjoiSUQifSx7ImlkIjoxMTYsIm5hbWUiOiJSSEVVTSJ9LHsiaWQiOjExNywibmFtZSI6IkVORE8ifSx7ImlkIjoxMTgsIm5hbWUiOiJTTEVFUCJ9LHsiaWQiOjExOSwibmFtZSI6Ik5FVVJPIn0seyJpZCI6MTIwLCJuYW1lIjoiSEVNIn0seyJpZCI6MTIxLCJuYW1lIjoiUkFEIn0seyJpZCI6MTIyLCJuYW1lIjoiR1MifSx7ImlkIjoxMjMsIm5hbWUiOiJDT0xPIn0seyJpZCI6MTI0LCJuYW1lIjoiVEhTVVJHIn0seyJpZCI6MTI1LCJuYW1lIjoiQ1ZTVVJHIn0seyJpZCI6MTI2LCJuYW1lIjoiVlNVUkcifSx7ImlkIjoxMjcsIm5hbWUiOiJPUlRITyJ9LHsiaWQiOjEyOCwibmFtZSI6Ik5TVVJHIn0seyJpZCI6MTI5LCJuYW1lIjoiQlNVUkcifSx7ImlkIjoxMzAsIm5hbWUiOiJUUlNVUkcifSx7ImlkIjoxMzEsIm5hbWUiOiJQTFNVUkcifSx7ImlkIjoxMzIsIm5hbWUiOiJUU1VSRyJ9LHsiaWQiOjEzMywibmFtZSI6Ik9TVVJHIn0seyJpZCI6MTM0LCJuYW1lIjoiRlQifSx7ImlkIjoxMzUsIm5hbWUiOiJVUk8ifSx7ImlkIjoxMzYsIm5hbWUiOiJPUFRIQUwifSx7ImlkIjoxMzcsIm5hbWUiOiJFTlQifSx7ImlkIjoxMzgsIm5hbWUiOiJERVJNIn0seyJpZCI6MTM5LCJuYW1lIjoiUE9EIn0seyJpZCI6MTQwLCJuYW1lIjoiREVOVCJ9LHsiaWQiOjE0MSwibmFtZSI6Ik9NU1VSRyJ9LHsiaWQiOjE0MiwibmFtZSI6IlBTWUNIIn0seyJpZCI6MTQ0LCJuYW1lIjoiUFNZQ0hPIn0seyJpZCI6MTQ1LCJuYW1lIjoiR1JQU1lDSCJ9LHsiaWQiOjE0NiwibmFtZSI6IkFJIn0seyJpZCI6MTQ3LCJuYW1lIjoiQU5FU1RIIn0seyJpZCI6MTQ5LCJuYW1lIjoiQkJUIn0seyJpZCI6MTUwLCJuYW1lIjoiT0JHWU4ifSx7ImlkIjoxNTMsIm5hbWUiOiJQQUxMSUFUSVZFIn0seyJpZCI6MTU0LCJuYW1lIjoiUkVIQUIifSx7ImlkIjoxNTUsIm5hbWUiOiJSQUQifSx7ImlkIjoxNTcsIm5hbWUiOiJQRUQifSx7ImlkIjoxNTgsIm5hbWUiOiJQRURIT1NQIn0seyJpZCI6MTU5LCJuYW1lIjoiUEVEQ0FSRCJ9LHsiaWQiOjE2MCwibmFtZSI6IlBFRE5FVVJPIn0seyJpZCI6MTYxLCJuYW1lIjoiUEVETkVVU1VSRyJ9LHsiaWQiOjE2MiwibmFtZSI6IlBFREVORE8ifSx7ImlkIjoxNjMsIm5hbWUiOiJQRURHSSJ9LHsiaWQiOjE2NCwibmFtZSI6IlBFREhFTSJ9LHsiaWQiOjE2NSwibmFtZSI6IlBFRElEIn0seyJpZCI6MTY2LCJuYW1lIjoiUEVEUFVMTSJ9LHsiaWQiOjE2NywibmFtZSI6IlBFRFJFSEFCIn0seyJpZCI6MTY4LCJuYW1lIjoiUEVEUFNZQ0gifSx7ImlkIjoxNjksIm5hbWUiOiJQRURERU5UIn0seyJpZCI6MTcwLCJuYW1lIjoiUEVET1JUSE8ifSx7ImlkIjoxNzEsIm5hbWUiOiJQRURCTVQifSx7ImlkIjoxNzIsIm5hbWUiOiJQRURBQlVTRSJ9LHsiaWQiOjE3MywibmFtZSI6IlBFRE5FUEgifSx7ImlkIjoxNzQsIm5hbWUiOiJQRURSSEVVTSJ9LHsiaWQiOjE3NSwibmFtZSI6IlBFRENWU1VSRyJ9LHsiaWQiOjE3NiwibmFtZSI6IlBFRFNVUkcifSx7ImlkIjoxNzcsIm5hbWUiOiJORU9OQVQifSx7ImlkIjoxNzksIm5hbWUiOiJQQUlOIn0seyJpZCI6MTgyLCJuYW1lIjoiRVIifSx7ImlkIjoxODUsIm5hbWUiOiJFQ01PIn0seyJpZCI6MTg2LCJuYW1lIjoiSU1NVU4ifSx7ImlkIjoxOTAsIm5hbWUiOiJBRE1TVVAifSx7ImlkIjoxOTEsIm5hbWUiOiJVUiJ9LHsiaWQiOjIxMywibmFtZSI6IkgifV19.6dfg9qpkk348SpKtTkn-Q8UOXGrIs6991G3P9tAxGfQ"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}

							<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>