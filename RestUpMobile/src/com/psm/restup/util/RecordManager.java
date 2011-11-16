package com.psm.restup.util;
import javax.microedition.rms.*;

//Record Stores Manager
public class RecordManager
{
	private String rsName;
	private RecordStore rs;
	
	//contructor
	public RecordManager(String rsName)
	{
		this.rsName = rsName;
	}
	
	//open a RS
	private void openRS()
	{
		try {
			rs = RecordStore.openRecordStore(rsName, true);
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
	}
	
	//close a RS
	private void closeRS()
	{
		try {
			if(rs != null)
				rs.closeRecordStore();
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
	}
	
	//add a record to the RS
	public void addRecord(String record)
	{
		openRS();
		
		byte[] rec = record.getBytes();
		try {
			rs.addRecord(rec, 0, rec.length);
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
		finally
		{
			closeRS();
		}
	}
	
	//replace a record in the RS
	public void setRecord(int id, String record)
	{
		openRS();
		
		byte[] rec = record.getBytes();
		try {
			rs.setRecord(id, rec, 0, rec.length);
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
		finally
		{
			closeRS();
		}
	}
	
	//return a record of the RS
	public String getRecord(int id)
	{
		openRS();
		String ret = "";
		try {
			ret = new String(rs.getRecord(id));
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
		finally
		{
			closeRS();
		}
		return ret;
		
	}
	
	//return the number of records stored in the RS
	public int numRecords()
	{
		openRS();
		int num = -1;
		try
		{
			num = rs.getNumRecords();
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
		finally
		{
			closeRS();
		}
		return num;
	}
	
	//delete the RS
	public void deleteRS()
	{
		try {
			RecordStore.deleteRecordStore(rsName);
		}
		catch(Exception e)
		{
			System.err.println(e);
		}
	}
}
		