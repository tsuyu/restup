package com.psm.restup.midlet;

import javax.microedition.lcdui.AlertType;
import javax.microedition.lcdui.Command;
import javax.microedition.lcdui.CommandListener;
import javax.microedition.lcdui.Display;
import javax.microedition.lcdui.Displayable;
import javax.microedition.lcdui.List;
import javax.microedition.midlet.MIDlet;


import com.psm.restup.gui.FormDownloadStatus;
import com.psm.restup.gui.FormLogin;
import com.psm.restup.gui.FormOrder;
import com.psm.restup.model.ActionStatus;
import com.psm.restup.util.ActionStatusParser;
import com.psm.restup.util.CommandBuilder;
import com.psm.restup.util.RecordManager;
import javax.microedition.lcdui.Alert;
import javax.microedition.lcdui.Image;
import javax.microedition.lcdui.Ticker;

public class MidletRestUP extends MIDlet implements CommandListener
{
	// menu items
	private static final String[] MENU_ITEMS = {"Order Form", "Download Order Status","Logout"};
	// display
	private Display display;
	
	// list representing the main menu
	private List lsMain;
	//commands for the main menu
	private Command cmExit = CommandBuilder.getExit();
	private Command cmSelect = CommandBuilder.getSelect();
	// form representing the login
	private FormLogin fmLogin;
	// write post form
	private FormOrder fmOrder;
	// download post form
	private FormDownloadStatus fmDownloadStatus;

        private Image order,status,logout;

       String str = "Restaurant Service System Using PDA (RestUP)";

	public MidletRestUP()
	{
		super();

                 try{

            order = Image.createImage("/images/order.png");
            status = Image.createImage("/images/status.png");
            logout = Image.createImage("/images/logout.png");
            



                 }catch(Exception e){
                    System.err.println(e.getMessage());
                 }
                Image[] image = {order,status,logout};

              
              
		// main menu list
		lsMain = new List("RestUP", List.IMPLICIT, MENU_ITEMS,image);
		//add the commands to the main menu
		lsMain.addCommand(cmExit);
		lsMain.addCommand(cmSelect);
		//set the command listener 
		lsMain.setCommandListener(this);
		
		// the other displayable elements:
		// login form
		fmLogin = new FormLogin(this, lsMain);
		// write post form
		fmOrder = new FormOrder(this, lsMain);
		// write post form
		fmDownloadStatus = new FormDownloadStatus(this, lsMain);
                

        Ticker t = new Ticker(str);
        lsMain.setTicker(t);
	
		//the display
		display = Display.getDisplay(this);
		
	}

	protected void startApp()
	{
		// check if there is the login info already stored
		if (isLoginEmpty())
		{
			setDisplay(fmLogin);
		}
		else
		{
			setDisplay(lsMain);
		}
	}

	protected void pauseApp()
	{}

	protected void destroyApp(boolean unconditional)
	{
		lsMain = null;
		fmLogin = null;
		display = null;
	}
	
	public void shutDownApp(boolean unconditional)
	{
		destroyApp(unconditional);
		notifyDestroyed();
	}
	
	public void setDisplay(Displayable d)
	{
		display.setCurrent(d);
	}

	public void setDisplay(Alert a, Displayable d)
	{
		display.setCurrent(a, d);
	}
	
	public Displayable getMain()
	{
		return lsMain;
	}
	
	private boolean isLoginEmpty()
	{
		RecordManager rm = new RecordManager("LOGIN");
		return (rm.numRecords() < 2);
	}

	public void commandAction(Command c, Displayable d)
	{
		if(c == cmExit)
		{
			shutDownApp(false);
		}
		else if(c == cmSelect) 
		{
			// detect the menu item selected
			int menuIndex = lsMain.getSelectedIndex();
			
			switch(menuIndex)
			{
				case 0: // write post
				{
					System.out.println("Order Form");
					setDisplay(fmOrder);
					break;
				}
				case 1: // download post
				{
					System.out.println("Download Order Status");
					setDisplay(fmDownloadStatus);
					break;
				}
                                
				case 2: // logout
				{
					System.out.println("Logout");
					// delete the login data
					RecordManager rm = new RecordManager("LOGIN");
					rm.deleteRS();
					//clear the fields of the login form
					fmLogin.clearFields();
					//set fmLogin as the current display
					setDisplay(fmLogin);
					break;
				}
			}
		}
		
	}
        public void showStatus(String rawStatus, Displayable d)
	{

		ActionStatusParser pp = new ActionStatusParser(rawStatus);

		try
		{
			//extract the Complaint from the rawPost
			ActionStatus post = pp.parse();

		}
		catch(IllegalArgumentException iae)
		{
			System.out.println(iae.getMessage());
			//display alert
			showInfo(iae.getMessage(), d);
		}
		catch(IllegalStateException ise)
		{
			System.out.println(ise.getMessage());
			//display alert
			showInfo(ise.getMessage(), d);
		}
		catch(Exception e)
		{
			e.printStackTrace();
			//display alert
			showInfo(e.getMessage(), d);
		}
	}
	// show the info passed in
	public void showInfo(String info, Displayable d)
	{
		// create an alert
		Alert alert = new Alert("Info", info, null, AlertType.INFO);
		// modal alert
		alert.setTimeout(Alert.FOREVER);
		// show the alert
		setDisplay(alert, d);
	}
	
	// return the current display
	public Displayable getCurrentDisplay()
	{
		return display.getCurrent();
	}

}
