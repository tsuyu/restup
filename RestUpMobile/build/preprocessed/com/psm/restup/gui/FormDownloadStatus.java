package com.psm.restup.gui;


import com.psm.restup.connector.StatusRetriever;
import com.psm.restup.login.Login;
import com.psm.restup.midlet.MidletRestUP;
import com.psm.restup.util.CommandBuilder;
import com.psm.restup.util.RecordManager;
import javax.microedition.lcdui.Alert;
import javax.microedition.lcdui.AlertType;
import javax.microedition.lcdui.Choice;
import javax.microedition.lcdui.ChoiceGroup;
import javax.microedition.lcdui.Command;
import javax.microedition.lcdui.CommandListener;
import javax.microedition.lcdui.Displayable;
import javax.microedition.lcdui.Form;
import javax.microedition.lcdui.StringItem;
import javax.microedition.lcdui.TextField;



public class FormDownloadStatus extends Form implements CommandListener
{
	//midlet
	private MidletRestUP midlet;
	//previous display
	private Displayable previousDisplay;
	
	//items

	
	//commands
	private static final Command cmExit = CommandBuilder.getExit();
	private static final Command cmDownload = CommandBuilder.getDownload();
	private static final Command cmBack = CommandBuilder.getBack();
    private StringItem item;
    private final ChoiceGroup choiceTable;

	public FormDownloadStatus(MidletRestUP midlet, Displayable previousDisplay)
	{
		//call the Form constructor passing the title
		super("View Action Status");
		
		this.midlet = midlet;
		this.previousDisplay = previousDisplay;
		item = new StringItem("Info: ", "Please choose the tables");
		//append the items to the form

		//tfRefNo = new TextField("Ref. no :", "", 4, TextField.NUMERIC);
		String tables[] = {"A1", "A2", "A3","A4","A5","B6","B7","B8","B9","B10"};

                choiceTable = new ChoiceGroup(
		"Table : ",
		Choice.POPUP,tables, null);

		//append the items to the form
                append(item);
		append(choiceTable);
		
		//add the commands to the form
		addCommand(cmExit);
		addCommand(cmDownload);
		addCommand(cmBack);
		
		//set the command listener
		setCommandListener(this);	
	}

	//called when a command is selected
	public void commandAction(Command c, Displayable d)
	{
		if(c == cmExit)
		{
			midlet.shutDownApp(false);
            RecordManager rm = new RecordManager("LOGIN");
            rm.deleteRS();
		}
		else if(c == cmBack)
		{
			midlet.setDisplay(previousDisplay);
		}
		else if(c == cmDownload)
		{
			//retrieve login data
			Login login = new Login();
			//userid
			String userid = login.getUserid();
			//password
			String password = login.getPassword();
			
			//String refID = tfRefNo.getString();
			//retrieve the post

                         int i = choiceTable.getSelectedIndex();
                        String table = choiceTable.getString(i);

            
                StatusRetriever pr = new StatusRetriever(midlet, this,
				userid, password, table);
                pr.start();
            

            }

		}
		
	
    private void notValidData()
        {
            Alert alert = new Alert("Error", "You must supply reference number, try again", null, AlertType.INFO);
            alert.setTimeout(Alert.FOREVER);
            midlet.setDisplay(alert, this);
        }
}
