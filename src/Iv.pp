%skip space \s
%token qm \?
%token em \!
%token colon \:
%token ucond exists|not_exists|domain|domain_not|path|path_not
%token bcond true|false
%token regexp [^\r\n]+



#cond_def:
  (<qm> | <em>) cond() ::colon:: <regexp>

cond:
  <bcond> | <ucond>