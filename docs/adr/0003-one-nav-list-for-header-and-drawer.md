# One nav list in the HTML for header and Drawer

Figma draws the site navigation twice: inline in the desktop header, stacked in the mobile Drawer. In HTML there is a single `<nav>` list (Site menu links + Register), styled as the comma-separated row on desktop and shown inside the Drawer on mobile. Two lists would make screen-reader and keyboard users meet every link twice. The same Site menu also feeds the Footer, which prepends "Start here". Its items are fixed in code (#35: the Panel-editable menu field was removed); only the "Start here" and Register labels are Panel fields.
