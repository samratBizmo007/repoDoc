<h1 id="pataients_lists">Pataients Lists</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>get-pataients-lists.json</h4>
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
							<h3 id="type3">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input3">Input</h3>
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
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJob3NwaXRhbF9pZCI6MSwic2VydmljZV90ZWFtX2lkIjoyLCJlbXBsb3llZV9pZCI6Mjc1fQ.dTP5OgZogpjLrnMLCgWtW8Z2b1ReUoyUPz9krGRR5A0
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output3">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6NSwibmFtZSI6IkphbWVzIEJyb3duIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzgwNSIsInBhdF9yb29tIjozLCJwYXRfYmVkIjoxLCJiZWQiOiIzLTEiLCJncm91cF9pZCI6Ii1MMzdDSnlOSUpoNGtOb0VHaXJYIn0seyJpZCI6MTIsIm5hbWUiOiJPbGl2ZXIgVGhvbWFzIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzgxMiIsInBhdF9yb29tIjo2LCJwYXRfYmVkIjoyLCJiZWQiOiI2LTIiLCJncm91cF9pZCI6Ii1MM0hkcTdOMG8zRDNCOWI3TnpvIn0seyJpZCI6NDAsIm5hbWUiOiJSeWFuIENhcnRlciIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4NDAiLCJwYXRfcm9vbSI6MjAsInBhdF9iZWQiOjIsImJlZCI6IjIwLTIiLCJncm91cF9pZCI6Ii1MNzhEaFRGUmd5a0hCSHBCNEtlIn0seyJpZCI6NDIsIm5hbWUiOiJMZXZpIFBlcmV6IiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9wYXRpZW50LWRlZmF1bHQucG5nIiwibXJuIjoiOTgzNzg0MiIsInBhdF9yb29tIjoyMSwicGF0X2JlZCI6MiwiYmVkIjoiMjEtMiIsImdyb3VwX2lkIjoiLUw3OERoeFZfUVEwUTZ4QnVyT1QifV19.YtB2braNbE3-mCa3mgMMK1O8KSy9Ck0kRzNuYcXZUHY"
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