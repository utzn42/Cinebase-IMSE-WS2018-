package extras;

import java.awt.*;
import java.io.File;

public class FilePicker {

    /*public static String pickv1() {                                                                                     //"schirches" UI
        JFileChooser chooser = new JFileChooser();
        FileNameExtensionFilter filter = new FileNameExtensionFilter(
                "SQL Files", "sql");
        chooser.setFileFilter(filter);
        int returnVal = chooser.showOpenDialog(null);
        if (returnVal == JFileChooser.APPROVE_OPTION) {
            System.out.println("You chose to open this file: " +
                    chooser.getSelectedFile().getAbsolutePath());
            return chooser.getSelectedFile().getAbsolutePath();
        }
        return null;
    }*/

    public static String pickv2() {
        FileDialog dialog = new FileDialog((Frame) null, "Select File to Open");
        dialog.setMode(FileDialog.LOAD);
        dialog.setVisible(true);
        String file = new File(dialog.getFile()).getAbsolutePath();
        System.out.println(file + " chosen.");
        return file;
    }
}
