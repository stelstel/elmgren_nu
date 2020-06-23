<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<% Response.Expires = 1 %>
<html>
<head>
<title>Sökta Jobb</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="robots" content="noindex">
<%
	'Select the correct year and month in the list box... 
	'...according to what the user chose before pressing button
	Function showSelectList( yearB, monthB, yearE, monthE)
	
		Dim months(12)
		months(1) = "Januari"
		months(2) = "Februari"
		months(3) = "Mars"
		months(4) = "April"
		months(5) = "Maj"
		months(6) = "Juni"
		months(7) = "Juli"
		months(8) = "Augusti"
		months(9) = "September"
		months(10) = "Oktober"
		months(11) = "November"
		months(12) = "December"
		
		Dim twoFigures ' 01, 02, 03... in stead of 1, 2 , 3 for the months 
	
  		Response.Write("<form method='post' action='sokta_jobb.asp?showPart=true'>")
  		Response.Write("Visa fr&aring;n &Aring;r")
  		Response.Write("<select name='yearBegin'>")
    	Response.Write("<option value='chooseBeginYear' ")
		If yearB = "" Then
			Response.Write("selected")
		End If 
		Response.Write(">V&auml;lj &aring;r</option>")
		Response.Write("<option value='2004' ")
		If yearB = 2004 Then
			Response.Write("selected")
		End If
		Response.Write(">2004</option>")
		Response.Write("<option value='2005' ")
		If yearB = 2005 Then
			Response.Write("selected")
		End If
		Response.Write(">2005</option>")
		Response.Write("<option value='2006' ")
		If yearB = 2006 Then
			Response.Write("selected")
		End If
		Response.Write(">2006</option>")
		Response.Write("<option value='2007' ")
		If yearB = 2007 Then
			Response.Write("selected")
		End If
		Response.Write(">2007</option>")
  		Response.Write("</select>")
		Response.Write("M&aring;nad") 
 		Response.Write("<select name='monthBegin'>")
		Response.Write("<option value='chooseBeginMonth' ")
		If monthB < 1 Then
			Response.Write("selected")
		End If
		Response.Write(">V&auml;lj m&aring;nad</option>")
		
		For i = 1 To 12
			Response.Write("<option value=")
			
			If i < 10 Then
				twoFigures = "0" & CStr(i)
			Else
				twoFigures = CStr(i)
			End If
			
			Response.Write("'" & twoFigures & "'")
			
			If monthB = twoFigures Then
				Response.Write(" selected")
			End If
			response.Write(">" & months(i) & "</option>")
		Next
			
		Response.Write("</select>")
		Response.Write("  Till År")
		Response.Write("<select name='yearEnd'>")
    	Response.Write("<option value='chooseEndYear' ")
		If yearE = "" Then
			Response.Write("selected")
		End If 
		Response.Write(">V&auml;lj &aring;r</option>")
		Response.Write("<option value='2004' ")
		If yearE = 2004 Then
			Response.Write("selected")
		End If
		Response.Write(">2004</option>")
		Response.Write("<option value='2005' ")
		If yearE = 2005 Then
			Response.Write("selected")
		End If
		Response.Write(">2005</option>")
		Response.Write("<option value='2006' ")
		If yearE = 2006 Then
			Response.Write("selected")
		End If
		Response.Write(">2006</option>")
		Response.Write("<option value='2007' ")
		If yearE = 2007 Then
			Response.Write("selected")
		End If
		Response.Write(">2007</option>")
		Response.Write("</select>")
		
 		Response.Write("M&aring;nad")
		Response.Write("<select name='monthEnd'>")
		Response.Write("<option value='chooseEndMonth' ")
		If monthE < 1 Then
			Response.Write("selected")
		End If
		Response.Write(">V&auml;lj m&aring;nad</option>")
		
		For i = 1 To 12
			Response.Write("<option value=")
			
			If i < 10 Then
				twoFigures = "0" & CStr(i)
			Else
				twoFigures = CStr(i)
			End If
			
			Response.Write("'" & twoFigures & "'")
			
			If monthE = twoFigures Then
				Response.Write(" selected")
			End If
			response.Write(">" & months(i) & "</option>")
		Next
		
		Response.Write("</select>")
		Response.Write("<input type='submit' name='Submit' value='Submit'>")
		Response.Write("</form>")
		
	End Function	
%>
</head>

<body>

<%
	yearBegin = Request.Form("yearBegin")
	monthBegin = Request.Form("monthBegin")
	yearEnd = Request.Form("yearEnd")
	monthEnd = Request.Form("monthEnd")
	
	If yearBegin = "" Then
		yearBegin = "2004"
	End If
	
	If monthBegin = "" Then
		monthBegin = "08"
	End If
	
	If yearEnd = "" Then
		yearEnd = "2007"
	End If
	
	If monthEnd = "" Then
		monthEnd = "06"
	End If
	
	Select Case monthEnd
      Case 2 endDate = 28
      Case 4, 6, 9, 11 endDate = 30
      Case 1,3,5,7,8,10,12 endDate = 31
    End Select
	
	call showSelectList(yearBegin, monthBegin, yearEnd, monthEnd)
%>

<table width="100%"  border="0" cellspacing="1" cellpadding="1">
<tr bgcolor="#9999FF">
  <td width="23%"><strong>Var</strong></td>
    <td width="20%"><strong>Info</strong></td>
    <td width="15%"><strong>Funktion</strong></td>
    <td width="10%"><strong>N&auml;r</strong></td>
    <td width="32%"><strong>Svar/Intervju</strong></td>
</tr>

<%
	dim rowCounter
	dim numberOfAnswers
	dim followUpcounter
	dim percentageAnswers
	dim percentageFollowUp
	
	followUpcounter = 0
	
	response.write("<strong>Visar " & yearBegin & "-" & monthBegin & "-01 - " & yearEnd & "-" & monthEnd & "-" & endDate & "</strong>")
	
	set conn=Server.CreateObject("ADODB.Connection")
	conn.Provider="Microsoft.Jet.OLEDB.4.0"
	
	conn.Open(Server.Mappath("../../db/sokta_jobb.mdb")) 
	set rs = Server.CreateObject("ADODB.recordset")
	
	'rs.Open "SELECT Var, Info, Funktion, Naar, Svar, followUp FROM Table1 WHERE Naar BETWEEN  #" & Request.Form("yearBegin") & "-" & Request.Form("monthBegin") & "-01# AND #" & Request.Form("yearEnd") & "-" & Request.Form("monthEnd") & "-" & endDate & "# ORDER BY Naar", conn
	rs.Open "SELECT Var, Info, Funktion, Naar, Svar, followUp FROM Table1 WHERE Naar BETWEEN  #" & yearBegin & "-" & monthBegin & "-01# AND #" & yearEnd & "-" & monthEnd & "-" & endDate & "# ORDER BY Naar", conn
	
	do until rs.EOF
		
		rowCounter = rowCounter + 1
		
		If rowCounter Mod 2 = 1 Then
			Response.Write("<tr bgcolor='#F5F5FF'>") 
		ElseIf rowCounter Mod 2 = 0 Then
			Response.Write("<tr>")
		End If
		
		If rs.Fields("Svar") <> "" Then
			numberOfAnswers = numberOfAnswers + 1
		End If
		
		Response.Write("<td>" & rs.Fields("Var") & "</td>")
		Response.Write("<td>" & rs.Fields("Info") & "</td>")
		Response.Write("<td>" & rs.Fields("Funktion") & "</td>")
		Response.Write("<td>" & rs.Fields("Naar") & "</td>")
		Response.Write("<td>" & rs.Fields("Svar") & "</td>")
		
		If rs.Fields("followUp") <> "" Then
			Response.Write("<tr bgcolor='#C8C8C8'><td colspan='5'><strong>" & rs.Fields("followUp") & "</strong><br>&nbsp;</td></tr>")
			followUpCounter = followUpCounter + 1
		End If
				
		Response.Write("</tr>")
				
		rs.MoveNext
	loop
	
	Response.Write("</table>")
	
	percentageAnswers = Round(numberOfAnswers / rowCounter * 100, 0)
	percentagefollowUp = Round(followUpCounter / rowCounter * 100, 0)
	
	Response.Write("<br><center><strong><bold>")
	Response.Write("Antal sökta jobb = " & rowCounter & "</bold></center></strong>")
	Response.Write("<center><strong><bold>Antal svar = " & numberOfAnswers & " (" & percentageAnswers & "%)</bold></center></strong>")
	Response.Write("<center><strong><bold>Antal uppföljningar/intervjuer = " & followUpCounter & " (" & percentageFollowUp & "%)")
	Response.Write("</bold></center></strong>")
	
	rs.close
	conn.close
	
	''''''''''''''''''''''''document.form.
%>
    
</p>
</body>
</html>
