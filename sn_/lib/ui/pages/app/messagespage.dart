import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:sn/providers/messagesprovider.dart';
import 'package:sn/providers/sys/baseproviders.dart';
import 'package:sn/ui/pages/app/messagepage.dart';
import 'package:sn/ui/widgets/message/messagewidget.dart';
import 'package:timeago/timeago.dart' as timeago;

class MessagesPage extends StatefulWidget {
  const MessagesPage({Key? key}) : super(key: key);

  @override
  _MessagesPageState createState() => _MessagesPageState();
}

class _MessagesPageState extends State<MessagesPage> {
  @override
  void initState() {
    super.initState();
    backend<MessagesProvider>().setMessage();
  }

  @override
  Widget build(BuildContext context) {
    return Consumer<MessagesProvider>(builder: (context, message, child) {
      return RefreshIndicator(
          child: ListView.builder(
              shrinkWrap: true,
              itemCount: message.messages.length,
              itemBuilder: (context, index) {
                final msg = message.messages[index];
                return MessageWidget(
                    image: Image.network(msg.userimage),
                    ontap: () {
                      Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (_) => MessagePage(
                                  id: "${msg.user_id_from ?? ""}")));
                    },
                    title: "${msg.user}",
                    timeago:
                        "${timeago.format(DateTime.parse(msg.messaged_date))}",
                    subtitle: "${msg.message}");
              }),
          onRefresh: () => backend<MessagesProvider>().setMessage(),
          key: GlobalKey<RefreshIndicatorState>());
    });
  }
}
