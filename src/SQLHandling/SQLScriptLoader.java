package SQLHandling;

import extras.FilePicker;

import javax.swing.*;
import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;

public class SQLScriptLoader {

    public static void loadScript(Connection conn) throws IOException, SQLException {

        String createFile = FilePicker.pickv1();

        //createFile = FilePicker.pickv2();

        StringBuilder res = new StringBuilder();
        Statement create_stmt = conn.createStatement();

        FileReader fr = new FileReader(new File(createFile));
        BufferedReader br = new BufferedReader(fr);
        int j = 0;
        while (j <= 1000) {
            res.append(br.readLine());
            j++;
        }

        br.close();

        String[] insertArray = res.toString().split(";");

        for (int i = 0; i < insertArray.length - 1; ++i) {
            if (!insertArray[i].trim().equals("")) {
                create_stmt.executeUpdate(insertArray[i]);
                System.out.println("[" + i + "] >> " + insertArray[i]);
            }
        }

        create_stmt.close();
    }

    public static void performLoadScript(Connection conn) {
        try {
            SQLScriptLoader.loadScript(conn);
        } catch (IOException e1) {
            JOptionPane.showMessageDialog(null, "Error while loading file.");
        } catch (SQLException e1) {
            JOptionPane.showMessageDialog(null, "Error in SQL statement.");
        }
    }
}
