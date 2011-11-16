package com.psm.restup.login;
import com.psm.restup.util.RecordManager;

// the userid is stored at record 1
// the password is stored at record 2
public class Login
{
	private final String RS = "LOGIN";
	private RecordManager rm;
	
	public Login()
	{
		rm = new RecordManager(RS);
	}
	
	public String getUserid()
	{
		return rm.getRecord(1);
	}
	
	public String getPassword()
	{
		return rm.getRecord(2);
	}
	
	public void setUserid(String userid)
	{
		if(rm.numRecords() == 0)
		{ //rm empty so add the record
			rm.addRecord(userid);
		}
		else
		{
			//rm not empty, overwrite the record
			rm.setRecord(1, userid);
		}
	}
	
	public void setPassword(String password)
	{
		if(rm.numRecords() == 1)
		{ //rm empty so add the record
			rm.addRecord(password);
		}
		else
		{
			//rm not empty, overwrite the record
			rm.setRecord(2, password);
		}
	}
}